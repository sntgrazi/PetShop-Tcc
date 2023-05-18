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
      <form>
        <div class="selectCampoInfo">
          <label for="">Procurar tutor/a para vincular ao animal</label>
          <select id="selectTutores" class="selectTutores">
            <option value="" selected></option>
            <option v-for="cliente in clientes" :value="cliente.id">{{ cliente.nome }}</option>
          </select>
        </div>

        <table>
          <tr>
            <th>TUTOR</th>
            <th>ACOES</th>
          </tr>
          <tr v-for="tutor in tutores" :key="tutor">
            <td>{{ tutor.nome }}</td>
            <td v-if="tutores.length >= 1"> VER FICHA</td>
            <td v-if="tutores.length  > 1"> APAGAR CLIENTE</td>
          </tr>
        </table>
      </form>
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
#selectTutores.selectTutores+.select2-container .select2-selection {
  width: 460px;
  height: 35px;
}

.selectCampoInfo {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 5px;
  border-bottom: 1px solid #bebdbd;
  padding-bottom: 1.5rem;
}

.selectCampoInfo>label {
  color: #fff;
}
</style>

