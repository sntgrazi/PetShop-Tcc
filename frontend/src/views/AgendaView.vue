<template>
    <Navbar />
  <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal
            v-if="formActive"
            :tipo="'agenda'"
            :icon="'fa-calendar'"
            :inputsAgendamento="true"
            :toggle="toggleform"
            :userId="userId"
          />

          <!--<tabela :topoTabela="topoTabela" :dados="dadosTabela" :tipo="'agenda'" :toggle="toggleform" /> -->
          <FullCalendar :options="calendarOptions" id="calendar"/>
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
import { ref } from "vue";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

//import tabela from "@/components/tabela.vue";

export default {
  name: "AgendaView",
  components: {
    topo,
    modal,
    InfoAgenda,
    //tabela,
    //VueCal
    FullCalendar,
    Navbar
  },
  data() {
    return {
      topoTabela: ["ID", "CLIENTE", "PET", "SERVICO", "STATUS", "AÇOES"],
      dadosTabela: [],
      
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
      calendarOptions
    };
  },
  mounted() {
    this.getOrdens();
    
  },
};
</script>

<style>
.fc .fc-toolbar.fc-header-toolbar {
  margin: 10px;
}

</style>