<template>
  <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" />

          <vue-cal show-week-numbers :disable-views="['years', 'year']" locale="pt-br"  />
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
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";
import { ref } from "vue";


//import tabela from "@/components/tabela.vue";

export default {
  name: "AgendaView",
  components: {
    topo,
    modal,
    InfoAgenda,
    VueCal
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

    return {
      formActive,
      toggleform,
      userId,
    };
  },
  mounted() {
    this.getOrdens();

  },
};
</script>

<style>
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
}
</style>