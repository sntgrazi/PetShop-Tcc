<template>
  <div class="form-overlay"></div>
  <div class="modal" :class="{ active: active }">
    <div class="modal-header">
      <div class="titulo-modal">
        <i :class="['fa regular', icon]"></i>
        <h2>{{ titulo }}</h2>
      </div>
      <button
        type="button"
        @click="() => toggle()"
        id="close-modal"
        class="close"
      >
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <form @submit.prevent="userId == false ? submitForm() : editarForm()">
        <div class="form-inputs" v-show="etapaAtual === 1">
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
          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 2">
              Próxima etapa
            </button>
          </div>
        </div>

        <div class="form-inputs" v-show="etapaAtual === 2">
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
          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 1"> <i class="fa-solid fa-arrow-left"></i>
              Voltar
            </button>

            <button class="confirm">{{ botaoConfirm }}</button>
          </div>
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
      etapaAtual: 1,
      cliente: {},
      titulo:
        this.tipo === "cliente" ? "Cadastrar Cliente" : this.tipo == 'Pets' ? "Novo Pet" : "Novo Agendamento",
      botaoConfirm: this.tipo === "cliente" || this.tipo === "Pets" ? "Cadastrar" : "Agendar",
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
  width: 400px;
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
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #ccc;
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  color: #ffffff;
}
.modal-header i {
  font-size: 30px;
}

.titulo-modal {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  gap: 20px;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.form-inputs {
  display: flex;
  flex-direction: column;
 
}

.form-inputs label {
  color: white;
}

.form-inputs input {
  width: 300px;
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
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

.modal-footer button {
  background-color: #010d55;
  padding: 0.6rem 1.2rem;
  color: #fff;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
  opacity: 0.9;
  font-size: 1rem;
}

.modal-footer button i{
  margin-right: 5px;
}


.modal-footer .confirm {
  background-color: #010d55;
}

.close {
  border: none;
  background-color: transparent;
  cursor: pointer;
  color: #fff;
}

</style>