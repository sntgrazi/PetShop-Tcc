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

        <div class="form-inputs" v-show="etapaAtual === 1" v-if="mostrarInputsCadastro">
          <BaseInput :modelValue="cliente.nome" @update:modelValue="(newValue) => (cliente.nome = newValue)
            " :label="'Nome'"  :idInput="'inputName'" />

          <div class="colunaForm">
            <BaseInput :modelValue="cliente.cpf" @update:modelValue="(newValue) => (cliente.cpf = newValue)"
              :label="'Cpf'"  :idInput="'inputCpf'" />
            <BaseInput :modelValue="cliente.rg" @update:modelValue="(newValue) => (cliente.rg = newValue)" :label="'Rg'"
               :idInput="'inputRg'" />
          </div>

          <div class="colunaForm">
            <BaseInput :modelValue="cliente.telefone" @update:modelValue="(newValue) => (cliente.telefone = newValue)"
              :label="'Telefone'"  :idInput="'inputTelefone'" />
            <BaseInput :modelValue="cliente.email" @update:modelValue="(newValue) => (cliente.email = newValue)"
              :label="'Email'" :idInput="'inputEmail'" />
          </div>

          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 2">
              Próximo
            </button>
          </div>
        </div>

        <div class="form-inputs" v-show="etapaAtual === 2" v-if="mostrarInputsCadastro">
          <div class="colunaForm">
            <BaseInput :modelValue="cliente.cep" @update:modelValue="(newValue) => (cliente.cep = newValue)"
              :label="'Cep'"  :idInput="'inputCep'" />
              <button type="button" class="btn-pesquisar" @click="procurarEndereço" ><i class="fa-solid fa-magnifying-glass"></i></button>
              
            <BaseInput :modelValue="cliente.bairro" @update:modelValue="(newValue) => (cliente.bairro = newValue)"
              :label="'Bairro'" :idInput="'inputBairro'" />
          </div>
          <div class="colunaForm">
            <BaseInput :modelValue="cliente.rua" @update:modelValue="(newValue) => (cliente.rua = newValue)"
              :label="'Rua'"  :idInput="'inputRua'" />
          </div>

          <div class="colunaForm">
            <BaseInput :modelValue="cliente.cidade" @update:modelValue="(newValue) => (cliente.cidade = newValue)"
              :label="'Cidade'"  :idInput="'inputCidade'" />
            <BaseInput :modelValue="cliente.uf" @update:modelValue="(newValue) => (cliente.uf = newValue)" :label="'Uf'"
               :idInput="'inputUf'" />
            <BaseInput :modelValue="cliente.n_casa" @update:modelValue="(newValue) => (cliente.n_casa = newValue)"
              :label="'N°'" :idInput="'inputN_Casa'" />
          </div>

          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 1">
              <i class="fa-solid fa-arrow-left"></i>
              Voltar
            </button>
            <button class="confirm">{{ botaoConfirm }}</button>
          </div>
        </div>

        <div class="form-inputs" v-if="inputsAnimais">
          <div class="colunaForm">
            <BaseInput :modelValue="agenda.cliente" @update:modelValue="(newValue) => (agenda.cliente = newValue)"
              :label="'Cliente'"  :idInput="'inputCep'" />
              
            <BaseInput :modelValue="agenda.pet" @update:modelValue="(newValue) => (agenda.pet = newValue)"
              :label="'Pet'" :idInput="'inputBairro'" />
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import ApiController from "@/ApiController";
import BaseInput from "./BaseInput.vue";
import Swal from "sweetalert2";


export default {
  name: "Modal",
  emits: ["atualizarTabela"],
  props: [
    "userId",
    "tipo",
    "icon",
    "mostrarInputsCadastro",
    "mostrarInputsAgendamento",
    "inputsAnimais",
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
      agenda: {},
      cliente: {},
      endereco: {},
      titulo:
        this.tipo === "cliente"
          ? "Cadastrar Cliente"
          : this.tipo == "Pets"
            ? "Novo Pet"
            : "Novo Agendamento",
      botaoConfirm:
        this.tipo === "cliente" || this.tipo === "Pets"
          ? "Cadastrar"
          : "Agendar",
    };
  },
  methods: {
    async submitForm() {
      if (this.tipo == "cliente") {
        ApiController.cadastrarCliente(this.cliente)
          .then(() => {
            Swal.fire(
              '',
              'Cliente cadastrado com sucesso!',
              'success'
            )
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
          Swal.fire(
              '',
              'Cliente atualizado com sucesso!',
              'success'
            )
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
         this.cliente = cliente
         this.endereco = cliente.endereco.split(",")
         this.cliente.cep = this.endereco[0]
         this.cliente.bairro = this.endereco[1]
         this.cliente.rua = this.endereco[2]
         this.cliente.cidade = this.endereco[3]
         this.cliente.uf = this.endereco[4]
         this.cliente.n_casa = this.endereco[5]
        })
        .catch((error) => {
          console.log(error);
        });
    },
    procurarEndereço(){
      const url = `https://viacep.com.br/ws/${this.cliente.cep}/json/`;
      fetch(url).then(response => response.json()).then(data =>{
        this.cliente.rua = data.logradouro;
        this.cliente.bairro = data.bairro;
        this.cliente.uf = data.uf;
        this.cliente.cidade = data.localidade;
      }).catch(error => console.error(error));
    }
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
#inputEmail,
#inputCep {
  width: 210px;
}
.colunaForm #inputBairro {
  width: 170px;
}
.colunaForm #inputUf,
.colunaForm #inputN_Casa {
  width: 70px;
}
.colunaForm #inputRua {
  width: 400px;
}
.colunaForm #inputCidade {
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
#inputCep {
  padding-right: 40px; /* Espaçamento para o botão */
}
.btn-pesquisar {
  position: absolute;
  background-color: transparent;
  border: none;
  font-size: 1em;
  cursor: pointer;
  margin-top: 30px;
  margin-right: 20px;
}
@media screen and (max-width: 750px) {
  .colunaForm {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .colunaForm #inputCpf,
  .colunaForm #inputRg,
  .colunaForm #inputTelefone,
  .colunaForm #inputEmail,
  #inputName,
  .colunaForm #inputCep,
  .colunaForm #inputCidade,
  .colunaForm #inputUf,
  .colunaForm #inputBairro,
  .colunaForm #inputRua,
  .colunaForm #inputN_Casa {
    width: 300px;
  }
  .modal-footer {
    gap: 20px;
  }
  #inputCep {
  padding-right: 40px; /* Espaçamento para o botão */
}
.btn-pesquisar {
  position: absolute;
  background-color: transparent;
  border: none;
  font-size: 1em;
  cursor: pointer;
  margin-bottom: 75px;
  margin-left: 260px;
  padding: 10px;
}
}
@media screen and (max-width: 350px) {
  #modal {
    position: absolute;
    margin-top: 3rem;
  }
}
</style>