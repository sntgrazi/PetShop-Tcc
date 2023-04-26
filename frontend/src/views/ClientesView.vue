<template>
  <section>
    <div class="container">
      <topo :type="'Clientes'" :icon="'fa-plus'" :toggle="toggleModal" />
      <div class="content">
        <div class="main-content">
          <modal :tipo="'cliente'" :icon="'fa-user'" :mostrarInputsCadastro="true" @clienteAdicionado="getClientes" :toggle="toggleModal" :userId="userid" />
          <tabela :topoTabela="topoTabela" :dados="dadosTabela" :toggle="toggleModal" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import ApiController from "@/ApiController";
import modal from '../components/modal.vue';
import { ref } from "vue";

export default {
  name: "ClientesView",
  components: {
    tabela,
    topo,
    modal,
  },
  data(){
    return{
        topoTabela: ["ID", "NOME", "PETS", "CPF", "TELEFONE", "AÇÕES"],
        dadosTabela: [],
    }
  },
  mounted(){
    this.getClientes();
  },
  methods: {
    getClientes(){
      ApiController.getClientes().then(clientes =>{
        this.dadosTabela = clientes;
      }).catch(error => {
        console.log(error)
      })
    },
  },
  setup() {
    const userid = ref(false);

    function toggleModal(id) {
      const modal = document.querySelector("#modal");
      const fade = document.querySelector("#fade");
      modal.classList.toggle("hide");
      fade.classList.toggle("hide");

      if (id) {
        userid.value = id;
      }
    }

    return {
      toggleModal,
      userid,
    };
  },
};
</script>