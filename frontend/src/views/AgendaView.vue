<template>
      <section>
    <div class="container">
      <topo :type="'Agenda'" :icon="'fa-calendar'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
        <modal
            v-if="formActive"
            :tipo="'agenda'"
            :icon="'fa-calendar'"
            :mostrarInputsAgendamento="true"
            :toggle="toggleform"
            :userId="userId"
          />
          <tabela :topoTabela="topoTabela" />
        </div>
            <InfoAgenda />
      </div>
    </div>
  </section>
</template>

<script>
import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import ApiController from "@/ApiController";
import modal from "../components/modal/modal.vue";
import InfoAgenda from "@/components/InfoAgenda.vue";
import { ref } from "vue";

export default {
  name: "ClientesView",
  components: {
    tabela,
    topo,
    modal,
    InfoAgenda
},
  data() {
    return {
      topoTabela: ["Agenda"],
    };
  },
  setup() {
    const formActive = ref(false);
    const userId = ref(false);

    const toggleform = (id = false) => {
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
  }
}
</script>

<style>
</style>