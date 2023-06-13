<template>
  <section>
    <div class="custom-container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="custom-content">
        <loading :loading="loading" />
        <div class="custom-main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" @atualizarCalendario="getAllOrdens" />

          <FullCalendar ref="calendar" :options="calendarOptions" />


        </div>
        <InfoAgenda :agendaDados="agendaDados" @atualizarcalendario="getAllOrdens" :toggle="toggleform"
          @deletarAgendamento="deletarAgendamento" />

      </div>
    </div>
  </section>
</template>

<script>
import topo from "@/components/topo.vue";
import modal from "@/components/modal/modal.vue";
import InfoAgenda from "@/components/InfoAgenda.vue";
import Swal from "sweetalert2";
import ApiController from "@/ApiController";
import { ref } from "vue";
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list';
import loading from '../components/loading.vue';


export default {
  name: "AgendaView",
  components: {
    topo,
    modal,
    InfoAgenda,
    loading,
    FullCalendar
  },
  data() {
    return {
      agendamentos: [],
      calendarOptions: {
        plugins: [dayGridPlugin, listPlugin],
        initialView: 'listDay',
        height: "100%",
        locale: 'pt-br',
        headerToolbar: {
          left: 'today',
          center: 'prev,title,next',
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
      },
      agendaDados: [],
      loading: true,

    }
  },
  methods: {
    teste() {
      console.log('Testando');
    },
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


      try {
        this.loading = true;
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

        $('#offcanvasRight').offcanvas('show');
        this.loading = false;
      } catch (error) {
        console.log("Erro ao listar a ordem: ", error);
      }

    },
    async getAllOrdens() {
      try {

        this.loading = true;

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
            },

          };
        });



        this.calendarOptions.eventDidMount = function (info) {
          const status = info.event.extendedProps.status;

          if (status === 'Concluído') {
            var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
            if (dotEl) {
              dotEl.style.border = 'calc(10px/2) solid green';
            }
            var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
            if (dayGridDotEl) {
              dayGridDotEl.style.border = 'calc(10px/2) solid green';
            }
          } else if (status === 'Em atendimento') {
            var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
            if (dotEl) {
              dotEl.style.border = 'calc(10px/2) solid #191970';
            }
            var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
            if (dayGridDotEl) {
              dayGridDotEl.style.border = 'calc(10px/2) solid #191970';
            }
          } else if (status === 'Cancelado') {
            var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
            if (dotEl) {
              dotEl.style.border = 'calc(10px/2) solid red';
            }
            var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
            if (dayGridDotEl) {
              dayGridDotEl.style.border = 'calc(10px/2) solid red';
            }
          } else if (status === 'Aguardando atendimento') {
            var dotEl = info.el.getElementsByClassName('fc-list-event-dot')[0];
            if (dotEl) {
              dotEl.style.border = 'calc(10px/2) solid orange';
            }
            var dayGridDotEl = info.el.getElementsByClassName('fc-daygrid-event-dot')[0];
            if (dayGridDotEl) {
              dayGridDotEl.style.border = 'calc(10px/2) solid orange';
            }
          }
        };

        this.$nextTick(() => {
          this.$refs.calendar.getApi().setOption('eventDidMount', this.calendarOptions.eventDidMount);
        });

        this.calendarOptions.events = eventos;

        this.loading = false;
      } catch (error) {
        console.log("Erro ao listar as ordens de serviços: ", error);
      }
    },
    async deletarAgendamento(id) {
      try {
 
        const result = await Swal.fire({
          title: "Você tem certeza que deseja deletar esse Agendamento?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
        });

        if (result.isConfirmed) {
          $('#offcanvasRight').offcanvas('hide');
          await ApiController.deleteOrdem(id);
          await this.getAllOrdens();
          Swal.fire("", "Agendamento deletado com sucesso", "success");
        }
      } catch (error) {
        console.error("Erro ao deletar o agendamento: ", error);
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
    this.loading = true;


    this.getAllOrdens()
  }
}

</script>

<style>
.fc .fc-toolbar.fc-header-toolbar {
  margin: 15px;
}
.fc-toolbar-chunk > div{
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  
}

.fc-toolbar-chunk > div > .fc-prev-button{
  border-radius: 50%;
  margin-right: 10px;
  height: 35px;
  width: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.fc-toolbar-chunk > div > .fc-prev-button >  .fc-icon-chevron-left{
  font-size: 25px;
  vertical-align: baseline;

}

.fc-toolbar-chunk > div > .fc-next-button{
  border-radius: 50%;
  margin-left: 10px;
  height: 35px;
  width: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.fc-toolbar-chunk > div > .fc-next-button > .fc-icon-chevron-right{
  font-size: 25px;
  vertical-align: baseline;

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
  gap: 20px;
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