<template>
  <div class="form-overlayInfo"></div>
  <div class="modalInfo">
    <div class="modal-header">
      <div class="titulo-modal">
        <i :class="['fa regular', icon]"></i>
        <h2>{{ titulo }}</h2>
      </div>
      <button type="button" @click="() => toggleinfo()" id="close-modal" class="close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
    <div class="modal-body">
      <form class="modalInfoForm">
        <div class="form-inputs">
          <div class="selectCampo">
          <label for="tutor">Tutor</label>
          <select  id="select-tutorInfo" class="selectTutorInfo">
            <option v-for="tutor in tutores" :value="tutor.id" selected>{{ tutor.nome }}</option>
          </select>
        </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseInput from "./BaseInput.vue";
import ApiController from "@/ApiController";
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";

export default {
  name: "Modal",
  props: ["userId", "toggleinfo", "titulo", "icon"],
  components: {
    BaseInput
  },
  data() {
    return {
      tutores: []
    };
  },
  methods: {
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

    $("#select-tutorInfo").select2();
  }
};
</script>

<style>
.modalInfo{
  position: absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 480px;
  max-width: 90%;
  background-color: #02396f;
  padding: 1.2rem;
  border-radius: 0.5rem;
  z-index: 10;
}

.form-overlayInfo {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  z-index: 5;
}

#select-tutorInfo.selectTutorInfo + .select2-container .select2-selection{
  width: 440px;
}


</style>