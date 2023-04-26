<template>
  <div id="fade" class="hide"></div>
  <div id="modal" class="hide">
    <div class="modal-header">
      <i :class="['fa regular', icon]"></i>
      <h2>{{ titulo }}</h2>
    </div>
    <div class="modal-body">
      <form @submit.prevent="submitForm">
        <div class="inputs">
          <BaseInput
            :modelValue="cliente.nome"
            @update:modelValue="(newValue) => (cliente.nome = newValue)"
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
            @click="toggle"
            id="close-modal"
            class="close"
          >
            Fechar
          </button>
          <button class="confirm">
            {{ botaoConfirm }}
          </button>
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
  props: {
    tipo: {
      type: String,
      required: true,
      validator: (value) => ["cliente", "agendamento"].includes(value),
    },
    icon: String,
    mostrarInputsCadastro: {
      type: Boolean,
      default: false,
    },
    mostrarInputsAgendamento: {
      type: Boolean,
      default: false,
    },
    modoEdição: {
      type: Boolean,
      default: false,
    },
    toggle: Function,
    userId: Boolean,
  },
  components: {
    BaseInput,
  },
  data() {
    return {
      cliente: {},
      titulo: this.tipo === "cliente" ? "Cadastro de Cliente" : "Novo Agendamento",
      botaoConfirm: this.tipo === "cliente" ? "Cadastrar" : "Agendar",
    };
  },
  methods: {
    submitForm() {
      if (this.tipo == "cliente") {
        ApiController.cadastrarCliente(this.cliente)
          .then(() => {
            this.$emit("clienteAdicionado");
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
  },
  emits: ["clienteAdicionado"],
};
</script>

<style>
#fade {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  z-index: 5;
}

#modal {
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

#fade,
#modal {
  transition: 0.5s;
  opacity: 1;
  pointer-events: all;
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

.modal-body p {
  margin-bottom: 1rem;
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

#modal.hide,
#fade.hide {
  opacity: 0;
  pointer-events: none;
}

#modal.hide {
  top: 0;
}

@media screen and (max-width: 750px) {
  .inputs {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .form-inputs input,
  .form-inputs input[type="date"],
  .form-inputs input[type="time"] {
    width: 250px;
  }
}

@media screen and (max-width: 350px) {
  #modal {
    position: absolute;
    margin-top: 3rem;
  }
}
</style>