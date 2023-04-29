<template>
    <section>
    <div class="container">
      <topo :type="'Pets'" :icon="'fa-plus'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal
            v-if="formActive"
            :tipo="'Pets'"
            :icon="'fa-paw'"
            :toggle="toggleform"
            :userId="userId"
          />
          <tabela :topoTabela="topoTabela" :toggle="toggleform" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import modal from "../components/modal.vue";
import { ref } from "vue";

export default{
  name: "ClientesView",
  components: {
    tabela,
    topo,
    modal
  },
  data(){
    return{
        topoTabela: ["ID", "NOME", "RAÇA", "PELAGEM", "ESPECIE", "AÇÕES"],
    }
  },    
  setup(){
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