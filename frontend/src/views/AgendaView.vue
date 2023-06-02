<template>
    <Navbar />
  <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" />

<<<<<<< HEAD
          <vue-cal show-week-numbers :disable-views="['years', 'year']" locale="pt-br"  />
=======
          <!--<tabela :topoTabela="topoTabela" :dados="dadosTabela" :tipo="'agenda'" :toggle="toggleform" /> -->
          <FullCalendar :options="calendarOptions" id="calendar"/>
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090
        </div>

        <InfoAgenda />
      </div>
    </div>
  </section>
</template>

<script>
import Navbar from "@/components/navbar.vue";
import topo from "@/components/topo.vue";
import modal from "../components/modal/modal.vue";
import InfoAgenda from "@/components/InfoAgenda.vue";
import ApiController from "@/ApiController";
<<<<<<< HEAD
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";
import { ref } from "vue";

=======
import { ref } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090

//import tabela from "@/components/tabela.vue";

export default {
  name: "AgendaView",
  components: {
    topo,
    modal,
    InfoAgenda,
<<<<<<< HEAD
    VueCal
=======
    //tabela,
    //VueCal
    FullCalendar,
    Navbar
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090
  },
  data() {
    return {
      topoTabela: ["ID", "CLIENTE", "PET", "SERVICO", "STATUS", "AÇOES"],
      dadosTabela: [],
<<<<<<< HEAD

=======
      
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090
    };
  },
  methods: {
    async getOrdens() {
      try {
        const ordens = await ApiController.getAllOrdens();
        this.dadosTabela = ordens;
        console.log(ordens);
      } catch (error) {
        console.log("Erro ao listar as ordens de serviços: ", error);
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

    const calendarOptions = {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: "dayGridMonth",
        height: "100%",
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth"
        },
        buttonText: {
          today: "Hoje",
          month: "Mês",
          week: "Semana",
          day: "Dia",
        },
        locale: "pt-br"
    }

    return {
      formActive,
      toggleform,
      userId,
<<<<<<< HEAD
=======
      calendarOptions
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090
    };
  },
  mounted() {
    this.getOrdens();
<<<<<<< HEAD

=======
    
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090
  },
};
</script>

<style>
<<<<<<< HEAD
.vuecal__flex {
  border-radius: 20px 20px 0 0;
}

.vuecal__title-bar {
  background-color: #1e90ff;
  color: white;
}

.vuecal__arrow i.angle {
  color: white;
}

.vuecal__title button {
  color: white;
=======
.fc .fc-toolbar.fc-header-toolbar {
  margin: 10px;
>>>>>>> 5163e5a0f12f1182deabb72f39079cbbece77090
}
</style>