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
      <form class="formModal" @submit.prevent="userId == false ? FormCadastro() : FormEdit()">
        <loading :loading="loading" />
        <div class="form-inputs" v-show="etapaAtual === 1">
          <div class="inputsAnimais" v-if="inputsAnimais">
            <div class="container-fluid">
              <div class="col-sm-12">
                <div v-if="!userId">
                  <label for="tutor">Tutor</label>
                  <select v-model="animal.tutor_id" id="select-tutor" class="selectTutor">
                    <option v-for="tutor in tutores" :value="tutor.id" selected>
                      {{ tutor.nome }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <BaseInput :modelValue="animal.nome_pet" @update:modelValue="(newValue) => (animal.nome_pet = newValue)
                      " :label="'Pet'" :idInput="'inputPet'" />
                  </div>
                  <div class="col-6 col-sm-4">
                    <BaseInput :modelValue="animal.data_nascimento" @update:modelValue="(newValue) => (animal.data_nascimento = newValue)
                      " :label="'Nascimento'" :idInput="'inputDataNascimento'" :tipo="'date'" />
                  </div>
                  <div class="col-6 col-sm-2">
                    <div class="selectCampo">
                      <label for="sexo">Sexo</label>
                      <select v-model="animal.sexo" id="select-sexo" class="selectsForm selectSexo">
                        <option v-for="sexo in sexos" :value="sexo.id">
                          {{ sexo.nome }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <div class="col-6 col-sm-6">
                    <BaseInput :modelValue="animal.altura" @update:modelValue="(newValue) => (animal.altura = newValue)
                      " :label="'Altura'" :idInput="'inputAltura'" />
                  </div>
                  <div class="col-6 col-sm-6">
                    <BaseInput :modelValue="animal.peso" @update:modelValue="(newValue) => (animal.peso = newValue)
                      " :label="'Peso'" :idInput="'inputPeso'" />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="proxima-etapa" @click="proximo">
                Próximo
              </button>
            </div>
          </div>

        </div>
        <div class="form-inputs" v-show="etapaAtual === 2">
          <div class="inputsAnimais" v-if="inputsAnimais">
            <div class="container-fluid">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="selectCampo">
                      <label for="especie">Espécie</label>
                      <select v-model="animal.especie" id="select-especie" class="selectEspecie">
                        <option v-for="especie in especies" :value="especie.nome" selected>
                          {{ especie.nome }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="selectCampo">
                      <label for="raca">Raça</label>
                      <select v-model="animal.raca" id="select-raca" class="selectRaca">
                        <option v-for="breed in breeds" :value="breed.noma_raca">
                          {{ breed.noma_raca }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="selectCampo">
                      <label for="pelagem">Pelagem</label>
                      <select v-model="animal.pelagem" id="select-pelagem" class="selectPelagem">
                        <option v-for="pelagem in pelagens" :value="pelagem.tipo">
                          {{ pelagem.tipo }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="selectCampo">
                      <label for="porte">Porte</label>
                      <select v-model="animal.porte" id="select-porte" class="selectPorte">
                        <option v-for="porte in portes" :value="porte.tipo">
                          {{ porte.tipo }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="proxima-etapa" @click="voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar
              </button>

              <button class="confirm">
                {{ botaoConfirm }}
              </button>
            </div>
          </div>
        </div>
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
import BaseInput from '../BaseInput/BaseInput.vue';
import ApiController from "@/ApiController";
import "select2/dist/css/select2.css";
import "select2";
import $ from "jquery";
import Swal from "sweetalert2";
import loading from '../Outros/loading.vue';


export default {
  name: "ModalPet",
  props: ['tipo', 'icon', 'toggle', 'userId', 'inputsAnimais', 'infoTutores', 'active'],
  emits: ["atualizarTabela"],
  components: {
    BaseInput,
    loading
  },
  data() {
    return {
      tutores: [],
      tutoresVinculados: [],
      clienteSemVinculo: [],
      animal: {},
      portes: [],
      pelagens: [],
      breeds: [],
      especies: [
        { id: "dog", nome: "Cachorro" },
        { id: "cat", nome: "Gato" },
      ],
      sexos: [
        { id: "F", nome: "F" },
        { id: "M", nome: "M" },
      ],
      etapaAtual: 1,
      titulo: this.userId == false ? "Cadastrar Pet" : "Editar Pet",
      botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
      watchEnabled: true,
      loading: true
    }
  },
  methods: {
    proximo() {
      this.etapaAtual = 2
    },
    voltar() {
      this.etapaAtual = 1
    },
    async bucarDadosAnimal() {
      try {
        const animal = await ApiController.getAnimalById(this.userId);
        this.animal = animal;

        $("#select-sexo").select2();
        $("#select-sexo").val(animal.sexo).trigger("change");
        $("#select-sexo").on("change", (e) => {
          this.animal.sexo = $("#select-sexo option:selected").val();
        });

        $("#select-porte").select2();
        $("#select-porte").val(animal.porte).trigger("change");
        $("#select-porte").on("change", (e) => {
          this.animal.porte = $("#select-porte option:selected").val();
        });

        $("#select-pelagem").select2();
        $("#select-pelagem").val(animal.pelagem).trigger("change");
        $("#select-pelagem").on("change", (e) => {
          this.animal.pelagem = $("#select-pelagem option:selected").val();
        });

        $("#select-especie").select2();
        $("#select-especie").val(animal.especie).trigger("change");
        $("#select-especie").on("change", (e) => {
          this.animal.especie = $("#select-especie option:selected").val();
        });

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
    },
    async buscarCliente() {
      try {
        this.loading = true
        this.tutores = await ApiController.getClientes();
        this.loading = false
      } catch (error) {
        console.log("Erro ao listar os clientes: ", error);
      }
    },
    async buscarPortes() {
      try {
        const portes = await ApiController.buscarPortes();
        this.portes = portes
      } catch (error) {
        console.log('Erro ao tentar buscas os portes: ', error)
      }
    },
    async buscarPelagens() {
      try {
        const pelagens = await ApiController.buscarPelagens();
        this.pelagens = pelagens
      } catch (error) {
        console.log('Erro ao tentar buscas as pelagens: ', error)
      }
    },
    async buscarTutorVinculado() {
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
    async buscarClientesSemVinculo() {
      try {
        this.loading = true
        const clientesAnimais = await ApiController.getClientes();
        await this.buscarTutorVinculado();

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

          await this.buscarTutorVinculado();
          await this.buscarClientesSemVinculo();

          this.loading = false
          Swal.fire("", "Tutor removido com sucesso", "success");

        }
      } catch (error) {
        console.error("Erro ao remover o vínculo: ", error);
      }
    },
    async FormCadastro() {
      try {

        const camposValidos = this.validarCampos();

        if (!camposValidos) {
            return;
        }

        await ApiController.cadastrarAnimal(this.animal);
        Swal.fire("", "Animal cadastrado com sucesso!", "success");
        this.$emit("atualizarTabela");
        this.toggle();
        this.animal = {};
      } catch (error) {
        console.log(error);
      }
    },
    async FormEdit() {
      try {

        const camposValidos = this.validarCampos();

        if (!camposValidos) {
            return;
        }

        await ApiController.editarAnimal(this.userId, this.animal);
        Swal.fire("", "Animal atualizado com sucesso!", "success");
        this.$emit("atualizarTabela");
        this.toggle();
        this.animal = {};
      } catch (error) {
        console.log(error);
      }
    },

    validarCampos() {
            // Verificar se todos os campos obrigatórios estão preenchidos
            if (
                !this.animal.tutor_id ||
                !this.animal.nome_pet ||
                !this.animal.altura ||
                !this.animal.peso ||
                !this.animal.data_nascimento ||
                !this.animal.sexo ||
                !this.animal.especie ||
                !this.animal.raca ||
                !this.animal.porte ||
                !this.animal.pelagem

            ) {
                Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
                return false;
            }

            // Verificar o formato correto do nome
            const regexNome = /^[A-Za-z\s]+$/;
            if (!regexNome.test(this.animal.nome_pet)) {
                Swal.fire("Erro", "Digite apenas letras e espaços no nome do pet.", "error");
                return false;
            }

            // ...

            return true;
        },
  },

  mounted() {
    this.loading = true;
    this.buscarCliente()
    this.buscarPortes();
    this.buscarPelagens();

    if (this.userId == false) {
      $("#select-tutor").select2({
        placeholder: "Selecione um Tutor",
        width: "100%",
      });

      $("#select-tutor").on("change", (e) => {
        // Obtém a raça selecionada
        this.animal.tutor_id = $("#select-tutor option:selected").val();
      });

      $("#select-porte").select2({
        placeholder: "Selecione o porte",
        width: "100%"
      });

      $("#select-porte").on("change", (e) => {
        this.animal.porte = $("#select-porte option:selected").val();
      });

      $("#select-pelagem").select2({
        placeholder: "Selecione a pelagem",
        width: "100%"
      });

      $("#select-pelagem").on("change", (e) => {
        this.animal.pelagem = $("#select-pelagem option:selected").val();
      });

      $("#select-sexo").select2({
        width: "100%"
      });

      $("#select-sexo").on("change", (e) => {
        this.animal.sexo = $("#select-sexo option:selected").val();
      });

      $("#select-raca").select2({
        placeholder: "Selecione uma Raça",
        width: "100%"
      });

      $("#select-especie").select2({
        placeholder: "Selecione a especie",
        width: "100%"
      });

      $("#select-especie").on("change", async (e) => {
        try {
          this.loading = true
          // Obtém a espécie selecionada
          this.especie = e.target.value;
          this.animal.especie = this.especie;
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
      this.watchEnabled = false;

    } else {
      this.bucarDadosAnimal()
      this.buscarTutorVinculado()
      this.buscarClientesSemVinculo()

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

          await this.buscarClientesSemVinculo();
          this.tutores = response.data;

          this.loading = false

          Swal.fire("", "Tutor vinculado com sucesso", "success");
          $("#selectTutores").val(null).trigger("change");
        } catch (error) {
          console.log("Erro ao adicionar um vinculo: ", error);
        }
      });

      $("#select-tutor").select2({
        placeholder: "Selecione um Tutor",
        width: "100%",
      });

      $("#select-porte").select2({
        placeholder: "Selecione o porte",
        width: "100%"
      });

      $("#select-pelagem").select2({
        placeholder: "Selecione a pelagem",
        width: "100%"
      });

      $("#select-sexo").select2({
        width: "100%"
      });

      $("#select-raca").select2({
        placeholder: "Selecione uma Raça",
        width: "100%"
      });

      $("#select-especie").select2({
        placeholder: "Selecione a especie",
        width: "100%"
      });

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
  overflow: hidden;
  text-overflow: ellipsis;
  height: 45px;
  border: none;
  border-radius: 7px;
  font-size: 17px;
  outline: none;
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
</style>