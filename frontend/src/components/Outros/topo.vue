<template>
  <loading :loading="loading" />
  <div class="custom-row">
    <button @click="btnModal" id="open-modal">
      <i :class="['fa regular', icon]"></i>
      {{ botaoAdd }}
    </button>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import ApiController from "@/ApiController";
import loading from "./loading.vue";

export default {
  name: "topo",
  props: ["type", "icon", "toggle", "buscarHistorico"],
  data() {
    return {
      botaoAdd:
        this.type === "Clientes"
          ? "Novo Cliente"
          : this.type === "Pets"
          ? "Novo Pet"
          : this.type === "Agenda"
          ? "Novo Agendamento"
          : this.type === "Funcionario"
          ? "Novo Funcionário"
          : this.type === "Fornecedor"
          ? "Novo Fornecedor"
          : this.type === "Caixa"
          ? "Histórico"
          : "Novo Produto/Serviço",
          loading: true
    };
  },
  components: {
    loading
  },
  methods: {
    btnModal() {
      if (this.type === "Pets") {
        Swal.fire({
          showCloseButton: true,
          title: "Já possui um tutor cadastrado?",
          showCancelButton: true,
          confirmButtonText: "Sim",
          cancelButtonText: "Não",
          cancelButtonColor: "red",
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            // Abrir modal para cadastrar novo pet
            this.toggle("info", null);
          } else if (result.dismiss === Swal.DismissReason.close) {
            // Nada a fazer, o modal foi fechado pelo botão de fechar
          } else {
            // Redirecionar para a tela de cadastro de clientes
            window.localStorage.setItem("redirecionado", "true");
            window.location.href = "/clientes";
          }
        });
      } else if (this.type == "Caixa") {
        this.buscarHistorico();
      } else {
        this.toggle("info", false);
      }
    },
  },

  mounted(){
    this.loading = false
  }
};
</script>

<style>
.custom-row {
  display: flex;
  justify-content: flex-end;
}

#open-modal {
  padding: 0.6rem 1.2rem;
  background-color: #1e90ff;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1.1rem;
  margin-bottom: 15px;
  margin-right: 5px;
  transition: 0.2s all;
}

#open-modal i {
  font-size: 20px;
  margin-right: 10px;
}

#open-modal:active {
  transform: scale(0.95);
  box-shadow: 2px 2px var(--black);
}

@media screen and (max-width: 370px) {
  #open-modal {
    padding: 5px;
    width: 10em;
  }
}

@media screen and (max-width: 370px) {
  #open-modal {
    padding: 5px;
    width: 150px;
  }
}
</style>