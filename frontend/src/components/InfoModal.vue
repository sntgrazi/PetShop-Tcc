<template>
  <div class="form-overlay"></div>
  <div class="modal">
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
      <form>

        <label for="tutor">Tutor</label>
        <select  id="select-tutor">
          <option v-for="tutor in tutores" :value="tutor.id">{{ tutor.nome }}</option>
        </select>

        <table>
          <thead>
            <tr>Tutor</tr>
          </thead>
        </table>

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
  props: [
    "userId",
    "toggleinfo",
    "titulo",
    "icon"
  ],
  components: {
    BaseInput
  },
  data() {
    return {
      tutores: [],
    }
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
    },
  },
  mounted() {
    this.Clientes();

    $('#select-tutor').select2();
  }
}
</script>

<style>
.modal {
  position: absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 500px;
  max-width: 90%;
  background-color: #02396f;
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


.modal-footer {
  margin-top: 1rem;
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

.modal-footer button {
  background-color: #e2ebf4;
  padding: 0.6rem 1.2rem;
  color: #02396f;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
  opacity: 0.9;
  font: bold;
  font-size: 1.2rem;
}

.modal-footer button i {
  margin-right: 5px;
}

.modal-footer button:hover {
  transition: 1s;
  background-color: #0005;
  color: white;
}

.modal-footer .confirm {
  background-color: #02396f;
  color: white;
}

.close {
  border: none;
  background-color: transparent;
  cursor: pointer;
  color: #fff;
}

.close:hover {
  color: #0005;
  transition: 1s;
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
  .colunaForm #inputPorte {
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