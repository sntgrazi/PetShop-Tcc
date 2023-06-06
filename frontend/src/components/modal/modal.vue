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

        <modalEtapa01 :inputsCadastro="inputsCadastro" :cliente="cliente" :inputsAnimais="inputsAnimais" :animal="animal"
          :inputsAgendamento="inputsAgendamento" :agenda="agenda" :etapaAtual="etapaAtual" :userId="userId"
          @proximaEtapa="etapaAtual = 2" />

        <modalEtapa02 :inputsCadastro="inputsCadastro" :cliente="cliente" :inputsAnimais="inputsAnimais" :animal="animal"
          :inputsAgendamento="inputsAgendamento" :agenda="agenda" :etapaAtual="etapaAtual" :userId="userId"
          :botaoConfirm="botaoConfirm" :breeds="breeds" @voltarEtapa="etapaAtual = 1" @proximaEtapa="etapaAtual = 3" />


        <modalEtapa03 :inputsAgendamento="inputsAgendamento" :etapaAtual="etapaAtual" :agenda="agenda"
          :botaoConfirm="botaoConfirm" @voltarEtapa="etapaAtual = 2" />
      </form>


      <div class="infoTutoreAnimais" v-if="infoTutores">
        <form class="formInfo">
          <div class="colunaForm">
            <div class="selectCampoInfo">
              <label for>Procurar tutor/a para vincular ao animal</label>
              <select id="selectTutores" class="selectTutores">
                <option value selected></option>
                <option v-for="clienteanimal in clienteSemVinculo" :value="clienteanimal.id">
                  {{ clienteanimal.nome }}
                </option>
              </select>
            </div>
          </div>
        </form>

        <div class="containerTabela">
          <table class="tabelaTutores">
            <thead>
              <tr>
                <th>TUTOR</th>
                <th>AÇÕES</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="tutorVinculado in tutoresVinculados" :key="tutorVinculado">
                <td>{{ tutorVinculado.nome }}</td>
                <td class="btnTutores">
                  <button type="
                button" class="btn-acoes" v-if="tutoresVinculados.length >= 1">
                    <i class="fa-solid fa-user"></i>
                  </button>
                  <button type="
                button" @click="removerVinculo(tutorVinculado.id, userId)" class="btn-acoes"
                    v-if="tutoresVinculados.length > 1">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ApiController from "@/ApiController";
import modalEtapa01 from './modalEtapa01.vue';
import modalEtapa02 from './modalEtapa02.vue';
import modalEtapa03 from './modalEtapa03.vue';
import axios from "axios";
import Swal from "sweetalert2";
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";

export default {
  name: "Modal",
  emits: ["atualizarTabela", "atualizarCalendario"],
  props: [
    "userId",
    "tipo",
    "icon",
    "inputsCadastro",
    "inputsAgendamento",
    "inputsAnimais",
    "toggle",
    "active",
    "getClientes",
    "infoTutores",
    "tituloModal",
  ],
  components: {
    modalEtapa01,
    modalEtapa02,
    modalEtapa03
  },
  data() {
    return {
      // Cliente DATA
      etapaAtual: 1,
      cliente: {},
      titulo:
        this.tipo === "cliente"
          ? "Cadastrar Cliente"
          : this.tipo === "Pets"
            ? "Novo Pet"
            : "Novo Agendamento",
      botaoConfirm:
        this.tipo === "cliente" || this.tipo === "Pets"
          ? "Cadastrar"
          : "Agendar",

      // Animais DATA

      breeds: [],
      animal: {},
      tutores: [],
      watchEnabled: true,
      clienteSemVinculo: [],
      tutoresVinculados: [],

      // Agendamento DATA
      agenda: {},

    };
  },
  methods: {
    async submitForm() {
      if (this.tipo == "cliente") {
        try {
          await ApiController.cadastrarCliente(this.cliente);
          Swal.fire("", "Cliente cadastrado com sucesso!", "success");
          this.$emit("atualizarTabela");
          this.toggle();
          this.cliente = {};
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipo == "agenda") {
        try {
          await ApiController.inserirOrdem(this.agenda);
          Swal.fire("", "Agendamento feito com sucesso!", "success");
          this.toggle();
          this.$emit('atualizarCalendario');
          this.agenda = {};
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipo == "Pets") {
        try {
          await ApiController.cadastrarAnimal(this.animal);
          Swal.fire("", "Animal cadastrado com sucesso!", "success");
          this.$emit("atualizarTabela");
          this.toggle();
          this.animal = {};
        } catch (error) {
          console.log(error);
        }
      }
    },
    async editarForm() {
      if (this.tipo == "cliente") {
        try {
          await ApiController.editarCliente(this.userId, this.cliente);
          Swal.fire("", "Cliente atualizado com sucesso!", "success");
          this.$emit("atualizarTabela");
          this.toggle();
          this.cliente = {};
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipo == "agenda") {
        console.log("agendamento");
      } else if (this.tipo == "Pets") {
        try {
          await ApiController.editarAnimal(this.userId, this.animal);
          Swal.fire("", "Animal atualizado com sucesso!", "success");
          this.$emit("atualizarTabela");
          this.toggle();
          this.animal = {};
        } catch (error) {
          console.log(error);
        }
      }
    },
    async selectPet() {
      $("#select-especie").on("change", async (e) => {
        try {
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
          racas.forEach((raca) => {
            $("#select-raca").append(
              $("<option>", {
                value: raca.id,
                text: raca.name,
                "data-nome": raca.name,
              })
            );
          });

          $("#select-raca").trigger("change");

          $("#select-raca").on("change", (e) => {
            // Obtém a raça selecionada
            this.animal.raca = $("#select-raca option:selected").data("nome");
          });
        } catch (error) {
          console.log(error);
        }
      });
    },
    async buscar() {
      if (this.tipo == "cliente") {
        try {
          const cliente = await ApiController.cliente(this.userId);
          this.cliente = cliente;
          this.endereco = cliente.endereco.split(",");
          this.cliente.cep = this.endereco[0];
          this.cliente.bairro = this.endereco[1];
          this.cliente.rua = this.endereco[2];
          this.cliente.cidade = this.endereco[3];
          this.cliente.uf = this.endereco[4];
          this.cliente.n_casa = this.endereco[5];
        } catch (error) {
          console.log(error);
        }
      } else {
        try {
          const animal = await ApiController.animal(this.userId);
          this.animal = animal;

          $("#select-especie").select2();
          $("#select-especie").val(animal.especie).trigger("change");

          $("#select-raca").select2({
            placeholder: "Selecione uma Raça",
          });

          $("#select-raca").on("change", (e) => {
            this.animal.raca = $("#select-raca option:selected").val();
          });

          $("#select-especie").on("change", (e) => {
            this.animal.especie = $("#select-especie option:selected").val();
            this.watchEnabled = false;
            this.breeds = [];
            this.watchEnabled = true;
          });
        } catch (error) {
          console.log(error);
        }
      }
    },
    async procurarEndereço() {
      const url = `https://viacep.com.br/ws/${this.cliente.cep}/json/`;
      try {
        const response = await fetch(url);
        const data = await response.json();
        this.cliente.rua = data.logradouro;
        this.cliente.bairro = data.bairro;
        this.cliente.uf = data.uf;
        this.cliente.cidade = data.localidade;
      } catch (error) {
        console.error(error);
      }
    },
    async getTutorVinculado() {
      try {
        this.tutoresVinculados = await ApiController.getclienteVinculado(
          this.userId
        );
      } catch (error) {
        console.log("Erro ao procurar tutores: ", error);
      }
    },
    async ClientesSemVinculo() {
      try {
        const clientesAnimais = await ApiController.getClientes();
        await this.getTutorVinculado();

        const clienteSemVinculo = clientesAnimais.filter((cliente) => {
          return !this.tutoresVinculados.some(
            (tutor) => tutor.id === cliente.id
          );
        });

        this.clienteSemVinculo = clienteSemVinculo;
      } catch (error) {
        console.log("Erro ao listar os clientes: ", error);
      }
    },
    async removerVinculo(clienteid, animalid) {
      try {
        const { value: motivoExclusao } = await Swal.fire({
          title: "Motivo da exclusão",
          input: "textarea",
          inputPlaceholder: "Digite o motivo da exclusão...",
          showCancelButton: true,
          confirmButtonText: "OK",
          cancelButtonText: "Cancelar",
          inputAttributes: {
            required: "required",
          },
          validationMessage: "Por favor, digite um motivo.",
        });

        if (motivoExclusao) {
          await ApiController.deletarVinculo(clienteid, animalid);
          Swal.fire("", "Tutor removido com sucesso", "success");
          await this.getTutorVinculado();
          await this.ClientesSemVinculo();
        }
      } catch (error) {
        console.error("Erro ao remover o vínculo: ", error);
      }
    },
  },
  mounted() {

    if (this.userId != false) {
      this.titulo =
        this.tipo === "cliente"
          ? "Editar Cliente"
          : this.tituloModal === true
            ? "Tutores"
            : this.tipo == "Pets"
              ? "Editar Pet"
              : "Editar Agenda";

      this.botaoConfirm = "Editar";
      this.buscar();

      this.getTutorVinculado();
      this.ClientesSemVinculo();

      $("#selectTutores").select2({
        placeholder: "Selecione o tutor",
        width: "100%",
      });

      $("#selectTutores").on("select2:select", async (e) => {
        try {
          const tutor_id = e.params.data.id;
          const animal_id = this.userId;

          const response = await ApiController.adicionarVinculo(
            tutor_id,
            animal_id
          );
          Swal.fire("", "Tutor vinculado com sucesso", "success");
          this.ClientesSemVinculo();
          this.tutores = response.data;

          $("#selectTutores").val(null).trigger("change");
        } catch (error) {
          console.log("Erro ao adicionar um vinculo: ", error);
        }
      });
    } else if (this.userId == false) {
      $("#select-especie").select2({
        placeholder: "Selecione uma espécie",
      });

      $("#select-raca").select2({
        placeholder: "Selecione uma Raça",
      });

      this.selectPet();

      $("#select-especie").on("change", (e) => {
        // Obtém a raça selecionada
        this.animal.especie = $("#select-especie option:selected").val();
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
    },
  },
};
</script>

<style>


.select2-container .select2-selection {
  overflow: hidden;
  text-overflow: ellipsis;
  height: 40px;
  border: none;
  border-radius: 10px;
  font-size: 17px;
  outline: none;
  box-shadow: 0 0.4rem 0.8rem #0005;
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

.select2-container .select2-selection--single {
  text-align: center;
  display: flex;
  align-items: center;
}


@media screen and (max-width: 750px) {

  .select2-container .select2-selection,
  #select-tutor.selectTutor+.select2-container .select2-selection {
    width: 100%;
  }
}
</style>