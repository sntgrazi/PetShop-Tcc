<template>
  <section>
    <div class="custom-container">
      <topo :type="'Pets'" :icon="'fa-plus'" :toggle="toggleform" />
      <div class="custom-content">
        <div class="custom-main-content">
          <loading :loading="loading" />
          <modalPet v-if="formActive" :tipo="'Pets'" :icon="'fa-paw'" :toggle="toggleform" :userId="userId"
            :inputsAnimais="inputsAnimais" @atualizarTabela="getAnimais" :infoTutores="mostrarInfoTutores" />

          <tabela :topoTabela="topoTabela" :dados="dadosTabela" :tipo="'pet'" @infoAnimal="offcanvasAnimal" />
          <InfoAnimal :pet="informacoesAnimal" @deletar="deletarAnimais" :toggle="toggleform" :tipo="'pet'" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>

import tabela from "@/components/Outros/tabela.vue";
import topo from "@/components/Outros/topo.vue";
import modalPet from "@/components/modal/modalPet.vue";
import InfoAnimal from "@/components/offCanvas/InfoAnimal.vue";
import { ref } from "vue";
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import loading from '../components/Outros/loading.vue';

export default {
  name: "AnimaisView",
  components: {
    tabela,
    topo,
    modalPet,
    InfoAnimal,
    loading
  },
  data() {
    return {
      topoTabela: ["ID", "PET", "SEXO", "RAÇA", "PORTE"],
      dadosTabela: [],
      loading: true,
      informacoesAnimal: []
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
        $('#offcanvasRight').offcanvas('hide');
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
        this.loading = true;
        const animais = await ApiController.getAnimais();
        this.dadosTabela = animais;

        this.loading = false;
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
          this.loading = true
          $('#offcanvasRight').offcanvas('hide');
          await ApiController.deletarAnimal(animalId);
          await this.getAnimais();
          this.loading = false
          Swal.fire("", "Pet deletado com sucesso", "success");


        }
      } catch (error) {
        console.error("Erro ao deletar o Animal: ", error);
      }
    },
    async offcanvasAnimal(id) {
      try {
        this.loading = true;
        this.informacoesAnimal = await ApiController.getAnimalById(id)
        $('#offcanvasRight').offcanvas('show');
        this.loading = false;
      } catch (error) {
        console.log("Erro ao procurar as informações do Pet: ", error);
      }

    }
  },
  mounted() {
    this.loading = true;
    this.getAnimais();
  },
};
</script>

<style></style>