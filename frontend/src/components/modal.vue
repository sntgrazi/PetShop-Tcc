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
          <div class="inputCadastroCliente" v-if="mostrarInputsCadastro">
            <BaseInput :modelValue="cliente.nome" @update:modelValue="(newValue) =>
              (cliente.nome = newValue)" :label="'Nome'" :idInput="'inputName'" />

            <div class="colunaForm">
              <BaseInput :modelValue="cliente.cpf" @update:modelValue="(newValue) =>
                (cliente.cpf = newValue)" :label="'Cpf'" :idInput="'inputCpf'" />

              <BaseInput :modelValue="cliente.rg" @update:modelValue="(newValue) =>
                (cliente.rg = newValue)" :label="'Rg'" :idInput="'inputRg'" />
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="cliente.telefone" @update:modelValue="(newValue) =>
                (cliente.telefone = newValue)" :label="'Telefone'" :idInput="'inputTelefone'" />

              <BaseInput :modelValue="cliente.email" @update:modelValue="(newValue) =>
                (cliente.email = newValue)" :label="'Email'" :idInput="'inputEmail'" />
            </div>
          </div>

          <div class="inputsAnimais" v-if="inputsAnimais">
            <BaseInput :modelValue="animais.tutor" @update:modelValue="(newValue) =>
              (animais.tutor = newValue)" :label="'Tutor'" :idInput="'inputTutor'" />

            <div class="colunaForm">
              <BaseInput :modelValue="animais.pet" @update:modelValue="(newValue) =>
                (animais.pet = newValue)" :label="'Pet'" :idInput="'inputPet'" />

              <BaseInput :modelValue="animais.data_nascimento" @update:modelValue="(newValue) =>
                (animais.data_nascimento = newValue)" :label="'Nascimento'" :idInput="'inputDataNascimento'" />

              <BaseInput :modelValue="animais.sexo" @update:modelValue="(newValue) =>
                (animais.sexo = newValue)" :label="'Sexo'" :idInput="'inputSexo'" />
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="animais.altura" @update:modelValue="(newValue) =>
                (animais.altura = newValue)" :label="'Altura'" :idInput="'inputAltura'" />

              <BaseInput :modelValue="animais.peso" @update:modelValue="(newValue) =>
                (animais.peso = newValue)" :label="'Peso'" :idInput="'inputPeso'" />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 2">Próximo</button>
          </div>
        </div>

        <div class="form-inputs" v-show="etapaAtual === 2">
          <div class="inputCadastroCliente" v-if="mostrarInputsCadastro">
            <div class="colunaForm">
              <BaseInput :modelValue="cliente.cep" @update:modelValue="(newValue) =>
                (cliente.cep = newValue)" :label="'Cep'" :idInput="'inputCep'" />

              <button type="button" class="btn-pesquisar" @click="procurarEndereço">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>

              <BaseInput :modelValue="cliente.bairro" @update:modelValue="(newValue) =>
                (cliente.bairro = newValue)" :label="'Bairro'" :idInput="'inputBairro'" />
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="cliente.rua" @update:modelValue="(newValue) =>
                (cliente.rua = newValue)" :label="'Rua'" :idInput="'inputRua'" />
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="cliente.cidade" @update:modelValue="(newValue) =>
                (cliente.cidade = newValue)" :label="'Cidade'" :idInput="'inputCidade'" />

              <BaseInput :modelValue="cliente.uf" @update:modelValue="(newValue) =>
                (cliente.uf = newValue)" :label="'Uf'" :idInput="'inputUf'" />

              <BaseInput :modelValue="cliente.n_casa" @update:modelValue="(newValue) =>
                (cliente.n_casa = newValue)" :label="'N°'" :idInput="'inputN_Casa'" />
            </div>
          </div>

          <div class="inputsAnimais" v-if="inputsAnimais">

            <div class="colunaForm">

              <div class="selectCampo">
                <label for="especie">Espécie</label>
                <select v-model="animais.especie" class="select-species">
                  <option value>Selecione a espécie</option>
                  <option value="dog">Cachorro</option>
                  <option value="cat">Gato</option>
                </select>
              </div>

              <div class="selectCampo"> 
                <label for="raca">Raça</label>
                <select v-model="animais.raca" class="select-breed">
                  <option value>Selecione a raça</option>
                  <option v-for="breed in breeds" :value="breed.name">{{ breed.name }}</option>
                </select>
              </div>
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="animais.pelagem" @update:modelValue="(newValue) =>
                (animais.pelagem = newValue)" :label="'Pelagem'" :idInput="'inputPelagem'" />

              <BaseInput :modelValue="animais.porte" @update:modelValue="(newValue) =>
                (animais.porte = newValue)" :label="'Porte'" :idInput="'inputPorte'" />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="etapaAtual = 1">
              <i class="fa-solid fa-arrow-left"></i> Voltar
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
import Swal from "sweetalert2";
import axios from "axios";

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
    "getClientes"
  ],
  components: {
    BaseInput
  },
  data() {
    return {
      // Cliente DATA
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
          : "Agendar",
      // Animais DATA
      breeds: [],
      animais: {},
    };
  },
  methods: {
    async submitForm() {
      if (this.tipo == "cliente") {
        ApiController.cadastrarCliente(this.cliente)
          .then(() => {
            Swal.fire("", "Cliente cadastrado com sucesso!", "success");
            this.$emit("atualizarTabela");
            this.toggle();
            this.cliente = {};
          })
          .catch(error => {
            console.log(error);
          });
      } else if (this.tipo == "agenda") {
        console.log("Agendamento");
      } else if (this.tipo == "Pets") {
        ApiController.inserirAnimal(this.animal).then(() => {
          Swal.fire("", "Cliente cadastrado com sucesso!", "success");
            this.toggle();
            this.animais = {};
        }).catch(error => {
          console.log(error);
        })
      }
    },
    async editarForm() {
      ApiController.editarCliente(this.userId, this.cliente)
        .then(() => {
          Swal.fire("", "Cliente atualizado com sucesso!", "success");
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
          this.endereco = cliente.endereco.split(",");
          this.cliente.cep = this.endereco[0];
          this.cliente.bairro = this.endereco[1];
          this.cliente.rua = this.endereco[2];
          this.cliente.cidade = this.endereco[3];
          this.cliente.uf = this.endereco[4];
          this.cliente.n_casa = this.endereco[5];
        })
        .catch(error => {
          console.log(error);
        });
    },
    async procurarEndereço() {
      const url = `https://viacep.com.br/ws/${this.cliente.cep}/json/`;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          this.cliente.rua = data.logradouro;
          this.cliente.bairro = data.bairro;
          this.cliente.uf = data.uf;
          this.cliente.cidade = data.localidade;
        })
        .catch(error => console.error(error));
    },
    async getBreeds(species) {

      const apiUrl = `https://api.the${species}api.com/v1/breeds`;

      try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        this.breeds = data;
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    if (this.userId != false) {
      (this.titulo = "Editar Cliente"), (this.botaoConfirm = "Editar");
      this.Cliente();
    }
  },
  watch: {
    "animais.especie"(newVal) {
      if (newVal) {
        this.getBreeds(newVal);
      } else {
        this.breeds = [];
      }
    },
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
  gap: 5px;
}

.form-inputs label {
  color: white;
  margin-top: 10px;
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

.colunaForm {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  gap: 20px;
}

#inputName,
#inputTutor {
  width: 440px;
}

.colunaForm #inputCpf,
#inputRg,
#inputTelefone,
#inputEmail,
#inputCep,
#inputPet,
#inputAltura,
#inputPeso,
#inputEspecie,
#inputPelagem,
#inputPorte,
#inputRaca {
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

.colunaForm #inputDataNascimento {
  width: 140px;
}

.colunaForm #inputSexo {
  width: 50px;
}

.select-species,
.select-breed {
  width: 210px;
  height: 35px;
  border: none;
  border-radius: 10px;
  font-size: 17px;
  outline: none;
  box-shadow: 0 0.4rem 0.8rem #0005;
}

.selectCampo{
  display: flex;
  flex-direction: column;
  gap: 5px;
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
  padding-right: 40px;
  /* Espaçamento para o botão */
}

.btn-pesquisar {
  position: absolute;
  background-color: transparent;
  border: none;
  font-size: 1em;
  cursor: pointer;
  margin-top: 35px;
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
  .colunaForm #inputN_Casa,
  #inputTutor,
  .colunaForm #inputPet,
  .colunaForm #inputDataNascimento,
  .colunaForm #inputSexo,
  .colunaForm #inputAltura,
  .colunaForm #inputPeso,
  .colunaForm #inputEspecie,
  .colunaForm #inputPelagem,
  .colunaForm #inputRaca,
  .colunaForm #inputPorte, .select-breed, .select-species {
    width: 300px;
  }

  .modal-footer {
    gap: 20px;
  }

  #inputCep {
    padding-right: 40px;
    /* Espaçamento para o botão */
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