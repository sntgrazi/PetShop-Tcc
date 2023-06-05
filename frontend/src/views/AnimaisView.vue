<template>
  <section class="home-section">
    <div class="container">
      <topo :type="'Pets'" :icon="'fa-plus'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tituloModal="tituloModal" :tipo="'Pets'" :icon="'fa-paw'" :toggle="toggleform"
            :userId="userId" :inputsAnimais="inputsAnimais" @atualizarTabela="getAnimais"
            :infoTutores="mostrarInfoTutores"/>
          <tabela :topoTabela="topoTabela" :dados="dadosTabela" :toggle="toggleform" @deletar="deletarAnimais" :tipo="'pet'"/>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import modal from "../components/modal/modal.vue";
import { ref } from "vue";
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import infoModal from "../components/modal/modalEtapa03.vue";

export default {
  name: "AnimaisView",
  components: {
    tabela,
    topo,
    modal,
    infoModal,
  },
  data() {
    return {
      topoTabela: ["ID", "PET", "SEXO", "RAÇA", "AÇÕES"],
      dadosTabela: [],
    };
  },
  setup() {
    const mostrarInfoTutores = ref(false);
    const formActive = ref(false);
    const userId = ref(false);
    const inputsAnimais = ref(false);
    const tituloModal = ref(false)

    const toggleform = (tipo, id = false) => {
      formActive.value = !formActive.value;
      userId.value = false;


      if (tipo == 'tutores') {
        mostrarInfoTutores.value = true;
        inputsAnimais.value = false;
        tituloModal.value = true;
      } else if (tipo == 'info') {
        mostrarInfoTutores.value = false;
        inputsAnimais.value = true;
        tituloModal.value = false;
      }

      if (id) {
        userId.value = id;
        console.log(userId.value);
      }
    };

    return {
      formActive,
      toggleform,
      userId,
      mostrarInfoTutores,
      inputsAnimais,
      tituloModal
    };
  },
  methods: {
    async getAnimais() {
      try {
        const animais = await ApiController.getAnimais();
        this.dadosTabela = animais;
      } catch (error) {
        console.log("Erro ao listar os animais: ", error);
      }
    },
    async deletarAnimais(animalId) {
      try {
        const result = await Swal.fire({
          title: "Você tem certeza que deseja deletar este Pet?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
        });

        if (result.isConfirmed) {
          await ApiController.deletarAnimal(animalId);
          Swal.fire("", "Pet deletado com sucesso", "success");
          this.getAnimais();
         
        }
      } catch (error) {
        console.error("Erro ao deletar o Animal: ", error);
      }
    }
  },
  mounted() {
    this.getAnimais();
  },
};
</script>

<style></style>