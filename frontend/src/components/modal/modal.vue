<template>
  <div class="custom-form-overlay"></div>
  <div class="custom-modal" :class="{ active: active }">
    <div class="modal-header">
      <div class="titulo-modal">
        <i :class="['fa regular', icon]"></i>
        <h3>{{ titulo }}</h3>
      </div>
      <button type="button" @click="() => toggle()" id="close-modal" class="close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">

      <loading :loading="loading" />

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
import Swal from "sweetalert2";
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";
import loading from '../loading.vue';

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
    modalEtapa03,
    loading
  },
  data() {
    return {
      loading: true,
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
          this.$emit('atualizarCalendario');
          this.toggle();
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
        try {
          await ApiController.updateOrdem(this.userId, this.agenda);
          Swal.fire("", "Agendamento atualizado com sucesso!", "success");
          this.$emit("atualizarCalendario");
          this.toggle();
          this.agenda = {};
        } catch (error) {
          console.log(error);
        }
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
          this.loading = true
          // Obtém a espécie selecionada
          this.especie = e.target.value;

          // Busca as raças correspondentes na API The Dog API
          const response = await ApiController.buscarRaca(this.especie);
          const racas = response;

          // Limpa o select de raças e adiciona as novas opções
          $("#select-raca").empty();
          $("#select-raca").append(
            $("<option>", { value: "", text: "Selecione uma raça" })
          );
          racas.forEach((raca) => {
            $("#select-raca").append(
              $("<option>", {
                value: raca.id,
                text: raca.noma_raca,
                "data-nome": raca.noma_raca,
              })
            );
          });

          this.loading = false;

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
          this.loading = true;
          const cliente = await ApiController.cliente(this.userId);
          this.cliente = cliente;
          this.endereco = cliente.endereco.split(",");
          this.cliente.cep = this.endereco[0];
          this.cliente.bairro = this.endereco[1];
          this.cliente.rua = this.endereco[2];
          this.cliente.cidade = this.endereco[3];
          this.cliente.uf = this.endereco[4];
          this.cliente.n_casa = this.endereco[5];

          this.loading = false;
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipo == 'Pets') {
        try {
          this.loading = true;
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

          this.loading = false;
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipo == 'agenda') {
        try {
          this.loading = true
          const agendaById = await ApiController.getOrdensById(this.userId);

          $("#select-cliente").select2();
          $("#select-cliente").val(agendaById.cliente_id).trigger("change");

      
          const petList = await ApiController.getpetVinculado(agendaById.cliente_id);


          $("#select-pet").select2({
            data: petList.map((pet) => ({
              id: pet.id,
              text: pet.name
            }))
          });

        
          // Definir a opção selecionada com base em agendaById.animal_id
          $("#select-pet").val(agendaById.animal_id).trigger("change");


          $("#select-funcionario").select2();
          $("#select-funcionario").val(agendaById.funcionario_id).trigger("change");

          $("#select-servico").select2();
          $("#select-servico").val(agendaById.servico_id).trigger("change");

          this.agenda.data_inicio = new Date(agendaById.data_inicio).toISOString().slice(0, 10)
          this.agenda.data_termino = new Date(agendaById.data_termino).toISOString().slice(0, 10)

          this.agenda.hora_inicio = agendaById.hora_inicio;
          this.agenda.hora_termino = agendaById.hora_termino;

          this.loading = false
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
        this.loading = true
        this.tutoresVinculados = await ApiController.getclienteVinculado(
          this.userId
        );
        this.loading = false
      } catch (error) {
        console.log("Erro ao procurar tutores: ", error);
      }
    },
    async ClientesSemVinculo() {
      try {
        this.loading = true
        const clientesAnimais = await ApiController.getClientes();
        await this.getTutorVinculado();

        const clienteSemVinculo = clientesAnimais.filter((cliente) => {
          return !this.tutoresVinculados.some(
            (tutor) => tutor.id === cliente.id
          );
        });

        this.clienteSemVinculo = clienteSemVinculo;
        this.loading = false
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
          this.loading = true
          await ApiController.deletarVinculo(clienteid, animalid);

          await this.getTutorVinculado();
          await this.ClientesSemVinculo();

          this.loading = false
          Swal.fire("", "Tutor removido com sucesso", "success");

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
          this.loading = true
          const tutor_id = e.params.data.id;
          const animal_id = this.userId;

          const response = await ApiController.adicionarVinculo(
            tutor_id,
            animal_id
          );

          await this.ClientesSemVinculo();
          this.tutores = response.data;

          this.loading = false

          Swal.fire("", "Tutor vinculado com sucesso", "success");
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

      this.loading = false
      this.watchEnabled = false;
    }
  },
  watch: {
    "animal.especie": async function (newSpecies) {
      if (this.watchEnabled) {
        try {
          this.loading = true;
          const data = await ApiController.buscarRaca(newSpecies);
          this.breeds = data;

          this.loading = false;
          console.log(data)
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