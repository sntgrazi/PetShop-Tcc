<template>
  <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tipo="'agenda'" :icon="'fa-calendar'" :inputsAgendamento="true" :toggle="toggleform"
            :userId="userId" />
        
          <tabela :topoTabela="topoTabela" :dados="dadosTabela" :tipo="'agenda'" :toggle="toggleform" />
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
import { ref } from "vue";
import tabela from "@/components/tabela.vue";


export default {
  name: "AgendaView",
  components: {
    topo,
    modal,
    InfoAgenda,
    tabela
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
        console.log(ordens)
      } catch (error) {
        console.log("Erro ao listar as ordens de serviços: ", error)
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
  }
}
</script>

<style>


.fc .fc-toolbar{
  margin: 15px;
}
</style>