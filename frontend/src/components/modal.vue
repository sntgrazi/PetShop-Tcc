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
      <form class="formModal" @submit.prevent="userId == false ? submitForm() : editarForm()">
        <div class="form-inputs" v-show="etapaAtual === 1">
          <div class="inputCadastroCliente" v-if="mostrarInputsCadastro">
            <BaseInput :modelValue="cliente.nome" @update:modelValue="(newValue) =>
              (cliente.nome = newValue)" :label="'Nome'" :idInput="'inputName'" />

            <div class="colunaForm">
              <BaseInput :modelValue="cliente.cpf" @update:modelValue="(newValue) =>
                (cliente.cpf = newValue)" :label="'Cpf'" :idInput="'inputCpf'" />

              <BaseInput :modelValue="cliente.telefone" @update:modelValue="(newValue) =>
                (cliente.telefone = newValue)" :label="'Telefone'" :idInput="'inputTelefone'" />
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="cliente.email" @update:modelValue="(newValue) =>
                (cliente.email = newValue)" :label="'Email'" :idInput="'inputEmail'" />
            </div>
          </div>

          <div class="inputsAnimais" v-if="inputsAnimais">

            <div class="colunaForm">
              <div class="selectCampo" v-if="!userId">
              <label for="tutor">Tutor</label>
              <select v-model="animal.tutor_id" id="select-tutor" class="selectTutor">
                <option v-for="tutor in tutores" :value="tutor.id" selected>{{ tutor.nome }}</option>
              </select>
            </div>

            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="animal.nome_pet" @update:modelValue="(newValue) =>
                (animal.nome_pet = newValue)" :label="'Pet'" :idInput="'inputPet'" />

              <BaseInput :modelValue="animal.data_nascimento" @update:modelValue="(newValue) =>
                (animal.data_nascimento = newValue)" :label="'Nascimento'" :idInput="'inputDataNascimento'" />

              <BaseInput :modelValue="animal.sexo" @update:modelValue="(newValue) =>
                (animal.sexo = newValue)" :label="'Sexo'" :idInput="'inputSexo'" />
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="animal.altura" @update:modelValue="(newValue) =>
                (animal.altura = newValue)" :label="'Altura'" :idInput="'inputAltura'" />

              <BaseInput :modelValue="animal.peso" @update:modelValue="(newValue) =>
                (animal.peso = newValue)" :label="'Peso'" :idInput="'inputPeso'" />
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
                <select v-model="animal.especie" id="select-especie">
                  <option v-for="especie in especies" :value="especie.id" selected>{{ especie.nome }}</option>
                </select>
              </div>

              <div class="selectCampo">
                <label for="raca">Raça</label>
                <select v-model="animal.raca" id="select-raca">
                  <option v-for="breed in breeds" :value="breed.name">{{ breed.name }}</option>
                </select>
              </div>
            </div>

            <div class="colunaForm">
              <BaseInput :modelValue="animal.pelagem" @update:modelValue="(newValue) =>
                (animal.pelagem = newValue)" :label="'Pelagem'" :idInput="'inputPelagem'" />

              <BaseInput :modelValue="animal.porte" @update:modelValue="(newValue) =>
                (animal.porte = newValue)" :label="'Porte'" :idInput="'inputPorte'" />
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
import axios from "axios";
import Swal from "sweetalert2";
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";

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
    "mostratTutor"
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
      especies: [
        { id: "dog", nome: "Cachorro" },
        { id: "cat", nome: "Gato" }
      ],
      breeds: [],
      animal: {},
      tutores: [],
      watchEnabled: true
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
        ApiController.cadastrarAnimal(this.animal)
          .then(() => {
            Swal.fire("", "Animal cadastrado com sucesso!", "success");
            this.$emit("atualizarTabela");
            this.toggle();
            this.animal = {};
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    async editarForm() {
      if (this.tipo == "cliente") {
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
      } else if (this.tipo == "agenda") {
        console.log("agendamento");
      } else if (this.tipo == "Pets") {
        ApiController.editarAnimal(this.userId, this.animal)
          .then(() => {
            Swal.fire("", "Animal atualizado com sucesso!", "success");
            this.$emit("atualizarTabela");
            this.toggle();
            this.animal = {};
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    async selectPet() {
      $("#select-especie").on("change", async e => {
        // Obtém a espécie selecionada
        this.especie = e.target.value;

        // Busca as raças correspondentes na API The Dog API
        const response = await axios.get(
          `https://api.the${this.especie}api.com/v1/breeds`
        );
        const racas = response.data;

        // Limpa o select de raças e adiciona as novas opções
        $("#select-raca").empty();
        $("#select-raca").append(
          $("<option>", { value: "", text: "Selecione uma raça" })
        );
        racas.forEach(raca => {
          $("#select-raca").append(
            $("<option>", {
              value: raca.id,
              text: raca.name,
              "data-nome": raca.name
            })
          );
        });

        $("#select-raca").trigger("change");

        $("#select-raca").on("change", e => {
          // Obtém a raça selecionada
          this.animal.raca = $("#select-raca option:selected").data("nome");
        });
      });
    },
    async buscar() {
      if (this.tipo == "cliente") {
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
      } else {
        ApiController.animal(this.userId)
          .then(animal => {
            this.animal = animal;
            $("#select-especie").select2();
            $("#select-especie")
              .val(animal.especie)
              .trigger("change");
            $("#select-raca").select2({
              placeholder: "Selecione uma Raça"
            });
            $("#select-raca").on("change", e => {
              this.animal.raca = $("#select-raca option:selected").val();
            });

            $("#select-especie").on("change", e => {
              this.animal.especie = $("#select-especie option:selected").val();
              this.watchEnabled = false;
              this.breeds = [];
              this.watchEnabled = true;
            });
          })
          .catch(error => {
            console.log(error);
          });
      }
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
    async Clientes() {
      ApiController.getClientes()
        .then(clientes => {
          this.tutores = clientes;
        })
        .catch(error => {
          console.log("Erro ao listar os clientes: ", error);
        });
    }
  },
  mounted() {
    this.Clientes();
    if (this.userId != false) {
      (this.titulo = "Editar Cliente"), (this.botaoConfirm = "Editar");
      this.buscar();
    } else {
      $("#select-especie").select2({
        placeholder: "Selecione uma espécie"
      });

      $("#select-raca").select2({
        placeholder: "Selecione uma Raça"
      });

      this.selectPet();

      $("#select-especie").on("change", e => {
        // Obtém a raça selecionada
        this.animal.especie = $("#select-especie option:selected").val();
      });

      $("#select-tutor").select2({
        placeholder: "Selecione um Tutor",
        width: '100%'
      });

      $("#select-tutor").on("change", e => {
        // Obtém a raça selecionada
        this.animal.tutor_id = $("#select-tutor option:selected").val();
      });

      this.watchEnabled = false;
    }
  },
  watch: {
    "animal.especie": async function (newSpecies) {
      if (this.watchEnabled) {
        try {
          const response = await fetch(
            `https://api.the${newSpecies}api.com/v1/breeds`
          );
          const data = await response.json();
          this.breeds = data;
        } catch (error) {
          console.error(error);
        }
      }
    }
  }
};
</script>

<style>

.select2-container .select2-selection {
  width: 100%;
  height: 35px;
  border: none;
  border-radius: 10px;
  font-size: 17px;
  outline: none;
  box-shadow: 0 0.4rem 0.8rem #0005;
  text-align: justify;
  color: #000;
}

.select2-container .select2-dropdown .select2-search input {
  padding: 6px 6px;
  outline: none;
}

.select2.select2-container .select2-selection .select2-selection__rendered {
  color: #333;
  line-height: 32px;
  padding-right: 33px;
}

@media screen and (max-width: 750px) {
  .select2-container .select2-selection,
  #select-tutor.selectTutor+.select2-container .select2-selection {
    width: 300px;
  }

}
</style>