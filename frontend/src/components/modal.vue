<template>
  <div class="form-overlay"></div>
  <div class="modal" :class="{ active: active }">
    <div class="modal-header">
      <div class="titulo-modal">
        <i :class="['fa regular', icon]"></i>
        <h2>{{ titulo }}</h2>
      </div>
      <button type="button" @click="() => toggle()" id="close-modal" class="close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <form @submit.prevent="userId == false ? submitForm() : editarForm()">

        <div class="form-inputs" v-show="etapaAtual === 1">
          
          <BaseInput :modelValue="cliente.nome_completo" @update:modelValue="(newValue) => (cliente.nome_completo = newValue)
            " :label="'Nome'" v-if="mostrarInputsCadastro" :idInput="'inputName'" />
            
          <div class="colunaForm">
            <BaseInput :modelValue="cliente.cpf" @update:modelValue="(newValue) => (cliente.cpf = newValue)"
              :label="'Cpf'" v-if="mostrarInputsCadastro" :idInput="'inputCpf'" />
            <BaseInput :modelValue="cliente.rg" @update:modelValue="(newValue) => (cliente.rg = newValue)" :label="'Rg'"
              v-if="mostrarInputsCadastro" :idInput="'inputRg'" />
          </div>

          <div class="colunaForm">
            <BaseInput :modelValue="cliente.telefone" @update:modelValue="(newValue) => (cliente.telefone = newValue)"
              :label="'Telefone'" v-if="mostrarInputsCadastro" :idInput="'inputTelefone'" />
            <BaseInput :modelValue="cliente.email" @update:modelValue="(newValue) => (cliente.email = newValue)"
              :label="'Email'" v-if="mostrarInputsCadastro" :idInput="'inputEmail'" />
              
          </div>

          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 2">Próximo</button>
          </div>
        </div>

        <div class="form-inputs" v-show="etapaAtual === 2">
         <div class="colunaForm">
          <BaseInput :modelValue="cliente.cep" @update:modelValue="(newValue) => (cliente.cep = newValue)" :label="'Cep'"
            v-if="mostrarInputsCadastro" :idInput="'inputCep'" />
            <BaseInput :modelValue="cliente.bairro" @update:modelValue="(newValue) => (cliente.bairro = newValue)" :label="'Bairro'"
            v-if="mostrarInputsCadastro" :idInput="'inputBairro'" />
           
           
         </div>
         <div class="colunaForm">
       
          <BaseInput :modelValue="cliente.rua" @update:modelValue="(newValue) => (cliente.rua = newValue)" :label="'Rua'"
            v-if="mostrarInputsCadastro" :idInput="'inputRua'" />
           
         </div>

         <div class="colunaForm">
        
            <BaseInput :modelValue="cliente.cidade" @update:modelValue="(newValue) => (cliente.cidade = newValue)" :label="'Cidade'"
            v-if="mostrarInputsCadastro" :idInput="'inputCidade'" />
            <BaseInput :modelValue="cliente.uf" @update:modelValue="(newValue) => (cliente.uf = newValue)" :label="'Uf'"
            v-if="mostrarInputsCadastro" :idInput="'inputUf'" />
            <BaseInput :modelValue="cliente.N_casa" @update:modelValue="(newValue) => (cliente.N_casa = newValue)" :label="'N°'"
            v-if="mostrarInputsCadastro" :idInput="'inputN_Casa'" />
         </div>
         
          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 1">
              <i class="fa-solid fa-arrow-left"></i>
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
    "getClientes"
  ],
  components: {
    BaseInput
  },
  data() {
    return {
      etapaAtual: 1,
      cliente: {},
      titulo:
        this.tipo === "cliente"
          ? "Cadastrar Cliente"
          : this.tipo == "Pets"
            ? "Novo Pet"
            : "Novo Agendamento",
      botaoConfirm:
        this.tipo === "cliente" || this.tipo === "Pets"
          ? "Cadastrar"
          : "Agendar"
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
          .catch(error => {
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
        .catch(error => {
          console.log(error);
        });
    },
    async Cliente() {
      ApiController.cliente(this.userId)
        .then(cliente => {
          this.cliente = cliente;
        })
        .catch(error => {
          console.log(error);
        });
    },
    async Cliente() {
      ApiController.cliente(this.userId)
        .then(cliente => {
          this.cliente = cliente;
        })
        .catch(error => {
          console.log(error);
        });
    }
  },
  mounted() {
    if (this.userId != false) {
      (this.titulo = "Editar Cliente"), (this.botaoConfirm = "Editar");
      this.Cliente();
    }
  }
};
</script>

<style>
.modal {
  position: absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 500px;
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
  gap: 10px;
}

.form-inputs label {
  color: white;
}

.form-inputs input {
  width: 280px;
  height: 35px;
  border: none;
  border-radius: 10px;
  padding: 10px;
  box-shadow: 0 0.4rem 0.8rem #0005;
  font-size: 1.2em;
  background-color: #fff;
}

.form-inputs input[type="date"],
.form-inputs input[type="time"] {
  width: 220px;
}

.colunaForm {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  gap: 20px;
}

#inputName {
  width: 440px;
}

.colunaForm #inputCpf,
#inputRg,
#inputTelefone,
#inputEmail , #inputCep{
  width: 210px;
}

.colunaForm #inputBairro{
  width: 170px;
}

.colunaForm #inputUf, .colunaForm #inputN_Casa{
  width: 70px;
}

.colunaForm #inputRua{
  width: 400px;
}

.colunaForm #inputCidade{
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

.modal-footer button i {
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


@media screen and (max-width: 750px) {
  .colunaForm {
    display: flex;
    flex-direction: column;
    gap: 10px;
    
  }

  .colunaForm #inputCpf, .colunaForm #inputRg, .colunaForm #inputTelefone, .colunaForm #inputEmail, #inputName,.colunaForm #inputCep,.colunaForm #inputCidade, .colunaForm #inputUf, .colunaForm #inputBairro, .colunaForm #inputRua, .colunaForm #inputN_Casa{
    width: 300px;
  }

  .modal-footer{
    gap: 20px;
  }

}
@media screen and (max-width: 350px) {
  #modal {
    position: absolute;
    margin-top: 3rem;
  }
}
</style>