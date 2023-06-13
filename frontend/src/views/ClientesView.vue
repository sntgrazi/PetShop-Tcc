<template>
  <section>
    <div class="custom-container">
      <topo :type="'Clientes'" :icon="'fa-plus'" :toggle="toggleform" />
      <div class="custom-content">
        <loading :loading="loading" />
        <div class="custom-main-content">
          <modal v-if="formActive" :tipo="'cliente'" :icon="'fa-user'" :inputsCadastro="true"
            @atualizarTabela="getClientes" :toggle="toggleform" :userId="userId" />
          <tabela :topoTabela="topoTabela" :dados="dadosTabela" :toggle="toggleform" @deletar="deletarCliente"
            :tipo="'cliente'" @infoCliente="offcanvasCliente"/>
        </div>
        <infoCliente :cliente="informacoesCliente"/>
      </div>
    </div>
  </section>
</template>

<script>
import tabela from "@/components/tabela.vue";
import topo from "@/components/topo.vue";
import ApiController from "@/ApiController";
import modal from "@/components/modal/modal.vue";
import { ref } from "vue";
import Swal from "sweetalert2";
import loading from '../components/loading.vue';
import infoCliente from "@/components/infoCliente.vue";

export default {
  name: "ClientesView",
  components: {
    tabela,
    topo,
    modal,
    loading, 
    infoCliente
  },
  data() {
    return {
      topoTabela: ["ID", "NOME", "CPF", "TELEFONE", "AÇÕES"],
      dadosTabela: [],
      loading: true,
      informacoesCliente: []
    };
  },
  mounted() {
    this.loading = true;

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
    async getClientes() {
      try {
        this.loading = true;
        const clientes = await ApiController.getClientes();
        this.dadosTabela = clientes;

        this.loading = false;
      } catch (error) {
        console.log("Erro ao listar os clientes: ", error);
      }
    },

    async deletarCliente(clienteId) {
      try {
        const result = await Swal.fire({
          title: "Você tem certeza que deseja deletar este cliente?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
        });

        if (result.isConfirmed) {
          await ApiController.deletarCliente(clienteId);
          await this.getClientes();
          Swal.fire("", "Cliente deletado com sucesso", "success");
        }
      } catch (error) {
        console.error("Erro ao deletar o cliente: ", error);
      }
    },
    async offcanvasCliente(id){
      try {
        this.loading = true;
        this.informacoesCliente = await ApiController.getClienteById(id)
        $('#offcanvasRight').offcanvas('show');
        this.loading = false;
      } catch (error) {
        console.log("Erro ao procurar as informações do cliente: ", error);
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
};
</script>

<style></style>