<template>
  <section>
    <div class="custom-container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="custom-content">
        <div class="custom-main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" @atualizarCalendario="getAllOrdens" />

          <FullCalendar ref="calendar" :options="calendarOptions" />



          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasRightLabel">Agendamento</h5>

              <div class="btnAcaoOff">
                <button class="btnEditarOffCanvas" type="button"><i class="fa-solid fa-pen"></i></button>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
            </div>
            <div class="offcanvas-body">
              <div>
                <div class="servicoDetalhes">
                  <div class="detalhesTitulo">
                    <h4>{{ agendaDados.nome_servico }}</h4>
                  </div>
                  <hr>
                  <h6>Data e Hora</h6>
                  <p> {{ agendaDados.data_inicio }} - {{ agendaDados.hora_inicio }} ás {{ agendaDados.hora_termino }}</p>
                  <div class="servicoDetalhescolumn">
                    <div class="colunaDetalhes">
                      <h6>Duração Aprox.</h6>
                      <p>{{ agendaDados.duracao }}</p>
                    </div>
                    <div class="colunaDetalhes">
                      <h6>Profissional</h6>
                      <p>{{ agendaDados.nome_funcionario }}</p>
                    </div>
                  </div>
                </div>

                <div class="servicoDetalhes">
                  <div class="detalhesTitulo">
                    <h4> Status </h4>
                  </div>
                  <hr>
                  <div class="detalhesInfoStatus">
                    <span> <i class="fa-sharp fa-regular fa-circle-dot"></i> </span>
                    <span>{{ agendaDados.status }}</span>
                  </div>
                </div>


                <div class="servicoDetalhes">
                  <div class="detalhesTitulo">
                    <h4>Cliente</h4>
                  </div>
                  <hr>
                  <div class="detalhesCliente">
                    <span><i class="fa-solid fa-user"></i></span>
                    <span>{{ agendaDados.nome_cliente }}</span>
                  </div>
                  <div class="detalhesAnimal">
                    <span><i class="fa-solid fa-paw"></i></span>
                    <span>{{ agendaDados.nome_animal }}</span>
                  </div>
                </div>


                <div class="btnAcoesAgendamento">
                  <button  class="btnIniciar" type="button"> Iniciar Atendimento</button>
                  <button  class="btnCancelar" type="button"> Cancelar Agendamento</button>
                </div>
              </div>
            </div>
          </div>

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
          };
        });

        this.events = eventos;
        const calendarApi = this.$refs.calendar.getApi();
        calendarApi.removeAllEvents();
        calendarApi.addEventSource(eventos);
      } catch (error) {
        console.log("Erro ao listar as ordens de serviços: ", error);
      }
    },
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

.pointer-cursor {
  cursor: pointer;
}

.offcanvas-header > h5 {
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

.btnAcoesAgendamento{
  margin-top: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 10px;
}

.btnAcoesAgendamento > button{
  padding: 15px;
  border: none;
  border-radius: 15px;
  color: #fff;
  width: 250px;
}

.btnIniciar{
  background-color: rgb(66, 151, 66);
}

.btnCancelar{
  background-color: rgb(228, 48, 48);
}
</style>