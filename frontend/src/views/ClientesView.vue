<template>
  <section>
    <div class="container">
      <topo :type="'Clientes'" :icon="'fa-plus'" :toggle="toggleform" />
      <div class="content">
        <div class="main-content">
          <modal
            v-if="formActive"
            :tipo="'cliente'"
            :icon="'fa-user'"
            :mostrarInputsCadastro="true"
            @atualizarTabela="getClientes"
            :toggle="toggleform"
            :userId="userId"
          />
          <tabela
            :topoTabela="topoTabela"
            :dados="dadosTabela"
            :toggle="toggleform"
            @deletarCliente="deletarCliente"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import ApiController from "@/ApiController";
import modal from "../components/modal.vue";
import { ref } from "vue";
import Swal from "sweetalert2";

export default {
  name: "ClientesView",
  components: {
    tabela,
    topo,
    modal,
  },
  data() {
    return {
      topoTabela: ["ID", "NOME", "CPF", "TELEFONE", "AÇÕES"],
      dadosTabela: [],
    };
  },
  mounted() {
    this.getClientes();

    if (window.localStorage.getItem("redirecionado")) {
      // Exibe o alerta
      Swal.fire({
        title: "Faça o cadastro do tutor primeiro",
        icon: "warning",
        confirmButtonText: "Ok",
      }).then((result) => {
        this.toggleform();
      });

      window.localStorage.removeItem("redirecionado");

    }
  },
  methods: {
    getClientes() {
      ApiController.getClientes()
        .then((clientes) => {
          this.dadosTabela = clientes;
        })
        .catch((error) => {
          console.log("Erro ao listar os clientes: ", error);
        });
    },

    deletarCliente(clienteId) {
      Swal.fire({
        title: "Você tem certeza que deseja deletar este cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
      }).then((result) => {
        if (result.isConfirmed) {
          ApiController.deletarCliente(clienteId)
            .then((response) => {
              console.log("Cliente deletado com sucesso");
              this.getClientes();
            })
            .catch((error) => {
              console.error("Erro ao deletar o cliente: ", error);
            });
          Swal.fire("", "Cliente deletado com sucesso", "success");
        }
      });
    },
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
  },
};
</script>