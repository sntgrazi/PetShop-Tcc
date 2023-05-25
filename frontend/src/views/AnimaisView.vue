<template>
  <section>
    <div class="container">
      <topo :type="'Pets'" :icon="'fa-plus'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal v-if="formActive" :tipo="'Pets'" :icon="'fa-paw'" :toggle="toggleform" :userId="userId"
            :inputsAnimais="inputsAnimais" :formtutor="formtutores" @atualizarTabela="getAnimais" />
          <tabela :topoTabela="topoTabela" :dados="dadosTabela" :toggle="toggleform" :toggleInfo="toggleInfo"
            @deletar="deletarAnimais" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import { ref } from "vue";
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import modalInfo from "../components/modal/modalInfo.vue";
import modal from "../components/modal/modal.vue";

export default {
  name: "AnimaisView",
  components: {
    tabela,
    topo,
    modal,
    modalInfo,
  },
  data() {
    return {
      topoTabela: ["ID", "PET", "SEXO", "RAÇA", "AÇÕES"],
      dadosTabela: [],
    };
  },
  setup() {

    const formActive = ref(false);
    const userId = ref(false);
    const formInfo = ref(false);
    const formtutores = ref(false);
    const inputsAnimais = ref(false);

    const toggleform = (id = false, tipo) => {
      formActive.value = !formActive.value;
      userId.value = false;

      if (id) {
        userId.value = id;
        console.log(userId.value);
      }

      if (tipo == 'animais'){
        inputsAnimais.value = true;
        formtutores.value = false;
      } else if (tipo == 'tutores'){
        inputsAnimais.value = false;
        formtutores.value = true;
      }
    };

    const toggleInfo = (id = false) => {
      formInfo.value = !formInfo.value;
      userId.value = false;

      if (id) {
        userId.value = id;
        console.log(userId.value);
      }

    };

    return {
      formInfo,
      formActive,
      toggleform,
      toggleInfo,
      userId,
      inputsAnimais,
      formtutores
    };
  },
  methods: {
    getAnimais() {
      ApiController.getAnimais()
        .then((animais) => {
          this.dadosTabela = animais;
        })
        .catch((error) => {
          console.log("Erro ao listar os animais: ", error);
        });
    },
    deletarAnimais(animalId) {
      Swal.fire({
        title: "Você tem certeza que deseja deletar este Pet?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
      }).then((result) => {
        if (result.isConfirmed) {
          ApiController.deletarAnimal(animalId)
            .then((response) => {
              console.log("Pet deletado com sucesso");
              this.getAnimais();
            })
            .catch((error) => {
              console.error("Erro ao deletar o Animal: ", error);
            });
          Swal.fire("", "Pet deletado com sucesso", "success");
        }
      });
    },
  },
  mounted() {
    this.getAnimais();
  },
};
</script>

<style></style>