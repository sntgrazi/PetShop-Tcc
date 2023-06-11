<template>
  <section>
    <div class="custom-container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="custom-content">
        <div class="custom-main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" @atualizarCalendario="getAllOrdens" />

          <FullCalendar ref="calendar" :options="calendarOptions" />

          <InfoAgenda :agendaDados="agendaDados" @atualizarcalendario="getAllOrdens" />
        </div>


      </div>
    </div>
  </section>
</template>

<script>
import topo from "@/components/topo.vue";
import modal from "@/components/modal/modal.vue";
import InfoAgenda from "@/components/InfoAgenda.vue";
import ApiController from "@/ApiController";
import { ref } from "vue";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';


export default {
  name: "AgendaView",
  components: {
    topo,
    modal,
    InfoAgenda,
    //VueCal
    FullCalendar
  },
  data() {
    return {
      agendamentos: [],
      calendarOptions: {
        plugins: [dayGridPlugin, listPlugin, timeGridPlugin],
        initialView: 'listDay',
        height: "100%",
        locale: 'pt-br',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,dayGridWeek,listDay'
        },
        buttonText: {
          today: "Hoje",
          month: "Mês",
          week: "Semana",
          list: 'Dia'
        },
        events: [],
        eventClick: this.getAgendamentosDetalhes,
        eventMouseEnter: this.mouseHover,
        eventMouseLeave: this.mouseLeave,
        eventDidMount: this.getCores,
      },
      agendaDados: [],


    }
  },
  methods: {

    mouseHover(info) {
      const eventElement = info.el;
      this.togglePointerCursor(eventElement);
    },
    mouseLeave(info) {
      const eventElement = info.el;
      this.togglePointerCursor(eventElement);
    },

    togglePointerCursor(element) {
      if (element.classList.contains('pointer-cursor')) {
        element.classList.remove('pointer-cursor');
      } else {
        element.classList.add('pointer-cursor');
      }
    },
    async getAgendamentosDetalhes(info) {
      const eventId = info.event.id
      $('#offcanvasRight').offcanvas('show');
      console.log(eventId)
      try {
        const eventData = await ApiController.getOrdensById(eventId)
        this.agendaDados = eventData
        const dataInicio = new Date(`${eventData.data_inicio}T00:00:00Z`); // Adiciona 'T00:00:00Z' para especificar o formato UTC

        const dia = String(dataInicio.getUTCDate()).padStart(2, '0');
        const mes = String(dataInicio.getUTCMonth() + 1).padStart(2, '0');
        const ano = dataInicio.getUTCFullYear();

        this.agendaDados.id = eventId

        this.agendaDados.data_inicio = `${dia}/${mes}/${ano}`;

        this.agendaDados.hora_inicio = eventData.hora_inicio.substring(0, 5);
        this.agendaDados.hora_termino = eventData.hora_termino.substring(0, 5);
      } catch (error) {
        console.log("Erro ao listar a ordem: ", error);
      }

    },
    async getAllOrdens() {
      try {
        const ordens = await ApiController.getAllOrdens();
        this.agendamentos = ordens;
        const eventos = this.agendamentos.map(agendamento => {
        const startDateTime = new Date(`${agendamento.data_Inicio}T${agendamento.hora_inicio}`);
        const endDateTime = new Date(`${agendamento.data_Termino}T${agendamento.hora_termino}`);


          return {
            id: agendamento.id,
            title: agendamento.nome_servico,
            start: startDateTime,
            end: endDateTime,
            extendedProps: {
              status: agendamento.status
            }

          };
        });

        this.calendarOptions.events = eventos;


      } catch (error) {
        console.log("Erro ao listar as ordens de serviços: ", error);
      }
    },
    getCores(info) {
      if (info.event.extendedProps.status === 'Aguardando atendimento') {

        var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
        if (dotEl) {
          dotEl.style.border = 'calc(10px/2) solid yellow';
        }
        var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
        if (dayGridDotEl) {
          dayGridDotEl.style.border = 'calc(10px/2) solid yellow';
        }
      } else if (info.event.extendedProps.status === 'Em atendimento') {
        var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
        if (dotEl) {
          dotEl.style.border = 'calc(10px/2) solid #191970';
        }
        var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
        if (dayGridDotEl) {
          dayGridDotEl.style.border = 'calc(10px/2) solid #191970';
        }
      } else if (info.event.extendedProps.status === 'Cancelado') {
        var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
        if (dotEl) {
          dotEl.style.border = 'calc(10px/2) solid red';
        }
        var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
        if (dayGridDotEl) {
          dayGridDotEl.style.border = 'calc(10px/2) solid red';
        }
      } else if (info.event.extendedProps.status === 'Concluído') {
        var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
        if (dotEl) {
          dotEl.style.border = 'calc(10px/2) solid green';
        }
        var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
        if (dayGridDotEl) {
          dayGridDotEl.style.border = 'calc(10px/2) solid green';
        }
      }
    }


  },
  setup() {
    const formActive = ref(false);
    const userId = ref(false);

    const toggleform = (tipo, id = false) => {
      formActive.value = !formActive.value;
      userId.value = false;

      if (id) {
        userId.value = id;
        console.log(userId.value);
      }
    };


    return {
      formActive,
      toggleform,
      userId,
    };
  },
  mounted() {
    this.getAllOrdens()
  }
}

</script>

<style>
.fc .fc-toolbar.fc-header-toolbar {
  margin: 15px;
}

.fc .fc-list-empty {
  background-color: white;
  border-radius: 20px;
}

.fc .fc-view-harness-active>.fc-view {
  border-radius: 0 0 20px 20px;
}

.fc .fc-col-header-cell-cushion {
  color: white;
}

.pointer-cursor {
  cursor: pointer;
}

.offcanvas-header>h5 {
  font-size: 25px;
  font-weight: bold;
  color: gray;
}

.btnAcaoOff {
  font-size: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btnEditarOffCanvas {
  border: none;
  background-color: transparent;
  margin-right: 15px;
  color: gray;
}

.servicoDetalhes>.detalhesTitulo>h4 {
  font-weight: bold;
  color: #1e90ff;
}

.servicoDetalhes>h6 {
  color: gray;
}

.detalhesInfoStatus {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
}

.detalhesInfoStatus>span {
  color: orange;
  font-size: 20px;
}

.detalhesInfoStatus>span>i {
  font-size: 25px;
}

.servicoDetalhescolumn {
  display: flex;
  align-items: center;
  gap: 30px;
}

.colunaDetalhes>h6 {
  color: gray;
}

.detalhesCliente {
  display: flex;
  gap: 20px;
}

.detalhesCliente>span {
  font-size: 20px;
}

.detalhesCliente>span>i {
  font-size: 25px;
  color: #1e90ff;
}

.detalhesAnimal {
  margin-top: 15px;
  display: flex;
  gap: 20px;
}

.detalhesAnimal>span {
  font-size: 20px;
}

.detalhesAnimal>span>i {
  font-size: 25px;
  color: #1e90ff;
}

.btnAcoesAgendamento {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 10px;
}

.btnAcoesAgendamento>button {
  padding: 15px;
  border: none;
  border-radius: 15px;
  color: #fff;
  width: 250px;
}

.btnIniciar {
  background-color: rgb(66, 151, 66);
}

.btnCancelar {
  background-color: rgb(228, 48, 48);
}
</style>