<template>
  <div class="form-overlay"></div>
  <div class="modal">
    <div class="modal-header">
      <div class="titulo-modal">
        <i :class="['fa regular', icon]"></i>
        <h2>{{ titulo }}</h2>
      </div>
      <button type="button" @click="() => toggleInfo()" id="close-modal" class="close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <form class="formInfo">
        <div class="colunaForm">
          <div class="selectCampoInfo">
            <label for="">Procurar tutor/a para vincular ao animal</label>
            <select id="selectTutores" class="selectTutores">
              <option value="" selected></option>
              <option v-for="cliente in clientes" :value="cliente.id">{{ cliente.nome }}</option>
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
            <tr v-for="tutor in tutores" :key="tutor">
              <td>{{ tutor.nome }}</td>
              <td class="btnTutores">
                <button type="
                button" class="btn-acoes" v-if="tutores.length >= 1"><i class="fa-solid fa-user"></i></button>
                <button type="
                button" class="btn-acoes" v-if="tutores.length > 1"><i class="fa-solid fa-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
import ApiController from "@/ApiController";

export default {
  props: ["toggleInfo", "tipo", "icon", "userId"],
  mounted() {
    this.Clientes();
    this.getTutorVinculado();
    $("#selectTutores").select2({
      placeholder: "Selecione o tutor",
      width: '100%'
    });

  },
  data() {
    return {
      titulo: this.tipo === 'Tutores' ? "Tutores" : "",
      clientes: [],
      tutores: {}
    }
  },
  methods: {
    async Clientes() {
      ApiController.getClientes()
        .then(clientes => {
          this.clientes = clientes;
        })
        .catch(error => {
          console.log("Erro ao listar os clientes: ", error);
        });
    },

    async getTutorVinculado() {
      ApiController.getclienteVinculado(this.userId)
        .then(tutores => {
          this.tutores = tutores;
        }).catch(error => {
          console.log("Erro ao procurar tutores: ", error)
        })
    }
  }
};
</script>

<style>
.selectCampoInfo {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 5px;
  border-bottom: 1px solid #bebdbd;
  padding-bottom: 1.5rem;
}

.selectCampoInfo>label {
  margin-bottom: 10px;
  color: #fff;
}

.tabelaTutores {
  margin-top: 10px;
}

.tabelaTutores thead th:first-child {
  border-top-left-radius: 10px;
}

.tabelaTutores thead th:last-child {
  border-top-right-radius: 10px;
}

.tabelaTutores tbody {
  background-color: #ffffff;
}

.tabelaTutores tbody tr:last-child td:first-child {
  border-bottom-left-radius: 10px;
}

.tabelaTutores tbody tr:last-child td:last-child {
  border-bottom-right-radius: 10px;
}

.btnTutores button{
  width: 30px;
  height: 30px;
  font-size: 16px;
  background-color: rgb(71, 71, 71);
  color: #fff;
  margin-left: 10px;
}

@media screen and (max-width: 750px) {
  #selectTutores.selectTutores+.select2-container .select2-selection {
    width: 100%;
  }

}
</style>

