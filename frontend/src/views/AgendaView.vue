<template>
  <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" @atualizarCalendario="getAllOrdens" />

          <FullCalendar ref="calendar" :options="calendarOptions" />
        </div>
        <InfoAgenda />
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
        events: [

        ],
        eventClick: function(info){

        }
      },
    }
  },
  methods: {
    async getAgendamentosDetalhes(id){
      
    },
    async getAllOrdens() {
      try {
        const ordens = await ApiController.getAllOrdens();
        this.agendamentos = ordens;
        const eventos = this.agendamentos.map(agendamento => {
          const startDateTime = new Date(`${agendamento.data_Inicio}T${agendamento.hora_inicio}`);
          const endDateTime = new Date(`${agendamento.data_Termino}T${agendamento.hora_termino}`);

          return {
            title: agendamento.servico_id,
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
</style>