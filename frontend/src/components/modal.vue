<template>
  <div class="form-overlay"></div>
  <div class="modal" :class="{ active: active }">
    <div class="modal-header">
      <i :class="['fa regular', icon]"></i>
      <h2>{{ titulo }}</h2>
    </div>
    <div class="modal-body">
      <form @submit.prevent="userId == false ? submitForm() : editarForm()">
        <div class="inputs">
          <BaseInput
            :modelValue="cliente.nome_completo"
            @update:modelValue="
              (newValue) => (cliente.nome_completo = newValue)
            "
            :label="'Nome'"
            v-if="mostrarInputsCadastro"
          />
          <BaseInput
            :modelValue="cliente.qtd_pets"
            @update:modelValue="(newValue) => (cliente.qtd_pets = newValue)"
            :label="'Pets'"
            v-if="mostrarInputsCadastro"
          />
          <BaseInput
            :modelValue="cliente.cpf"
            @update:modelValue="(newValue) => (cliente.cpf = newValue)"
            :label="'Cpf'"
            v-if="mostrarInputsCadastro"
          />
          <BaseInput
            :modelValue="cliente.telefone"
            @update:modelValue="(newValue) => (cliente.telefone = newValue)"
            :label="'telefone'"
            v-if="mostrarInputsCadastro"
          />
        </div>
        <div class="modal-footer">
          <button
            type="button"
            @click="() => toggle()"
            id="close-modal"
            class="close"
          >
            Fechar
          </button>
          <button class="confirm">{{ botaoConfirm }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import ApiController from "@/ApiController";
import BaseInput from "./BaseInput.vue";

export default {
  name: "Modal",
  emits: ["atualizarTabela"],
  props: [
    "userId",
    "tipo",
    "icon",
    "mostrarInputsCadastro",
    "mostrarInputsAgendamento",
    "toggle",
    "active",
    "getClientes",
  ],
  components: {
    BaseInput,
  },
  data() {
    return {
      cliente: {},
      titulo:
        this.tipo === "cliente" ? "Cadastrar Cliente" : "Novo Agendamento",
      botaoConfirm: this.tipo === "cliente" ? "Cadastrar" : "Agendar",
    };
  },
  methods: {
    async submitForm() {
      if (this.tipo == "cliente") {
        ApiController.cadastrarCliente(this.cliente)
          .then(() => {
            this.$emit("atualizarTabela");
            this.toggle();
            this.cliente = {};
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        console.log("Agendamento");
      }
    },
    async editarForm() {
      ApiController.editarCliente(this.userId, this.cliente)
        .then(() => {
          this.$emit("atualizarTabela");
          this.toggle();
          this.cliente = {};
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async Cliente() {
      ApiController.cliente(this.userId)
        .then((cliente) => {
          this.cliente = cliente;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async Cliente() {
      ApiController.cliente(this.userId)
        .then((cliente) => {
          this.cliente = cliente;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    if (this.userId != false) {
      (this.titulo = "Editar Cliente"), (this.botaoConfirm = "Editar");
      this.Cliente();
    }
  },
};
</script>

<style>
.modal {
  position: absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 450px;
  max-width: 90%;
  background-color: #4d72d6;
  padding: 1.2rem;
  border-radius: 0.5rem;
  z-index: 10;
}

.form-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  z-index: 5;
}

.modal-header {
  display: flex;
  justify-content: center;
  align-items: center;
  border-bottom: 1px solid #ccc;
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  color: #ffffff;
  gap: 20px;
}

.modal-header i {
  font-size: 30px;
}

form {
  display: flex;
  flex-direction: column;
}

.inputs {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin: 5px auto;
}

.form-inputs {
  display: flex;
  flex-direction: column;
}

.form-inputs label {
  color: white;
}

.form-inputs input {
  width: 220px;
  height: 35px;
  border: none;
  border-radius: 10px;
  padding: 10px;
  box-shadow: 0 0.4rem 0.8rem #0005;
  font-size: 0.9em;
  background-color: #fff;
}

.form-inputs input[type="date"],
.form-inputs input[type="time"] {
  width: 220px;
}

.modal-footer {
  margin-top: 1rem;
  border-top: 1px solid #ccc;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-footer button {
  margin: 20px 0px 10px;
  padding: 0.6rem 1.2rem;
  background-color: #888;
  color: #fff;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
  opacity: 0.9;
  font-size: 1rem;
}

.modal-footer .confirm {
  background-color: #010d55;
}

.modal-footer .close {
  background-color: #9e0101;
}
</style>