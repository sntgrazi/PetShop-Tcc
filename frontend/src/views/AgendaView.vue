<template>
  <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" />

          <FullCalendar :options="calendarOptions"  :noEventsMessage="customNoEventsMessage"/>
          <!-- <vue-cal show-week-numbers :time="false" :disable-views="['years', 'year']" locale="pt-br" :events="agendamentos" />-->
        </div>

        <InfoAgenda />
      </div>
    </div>
  </section>
</template>

<script>
import topo from "@/components/topo.vue";
import modal from "../components/modal/modal.vue";
import InfoAgenda from "@/components/InfoAgenda.vue";
import ApiController from "@/ApiController";
//import VueCal from "vue-cal";
//import "vue-cal/dist/vuecal.css";
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
        headerToolbar:{
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
          {
            title: 'Banho e Tosa',
            start: '2023-06-04T09:00:00',
            end: '2023-06-04T12:00:00'
          },
        ]
      },
      customNoEventsMessage: 'Não há eventos para exibir',
    }
  },
  methods: {
    async getOrdens() {
      try {
        const ordens = await ApiController.getAllOrdens();
        this.dadosTabela = ordens;
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
    this.getOrdens()
  }
}

</script>

<style>
.fc .fc-toolbar.fc-header-toolbar{
  margin: 15px;
}
</style>