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
                button" @click="removerVinculo(tutor.id, userId)" class="btn-acoes" v-if="tutores.length > 1"><i
                    class="fa-solid fa-trash"></i></button>
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
import Swal from "sweetalert2";
import ApiController from "@/ApiController";

export default {
  props: ["toggleInfo", "tipo", "icon", "userId"],
  data() {
    return {
      titulo: this.tipo === 'Tutores' ? "Tutores" : "",
      clientes: [],
      tutores: []
    }
  },
  methods: {
    getTutorVinculado() {
      ApiController.getclienteVinculado(this.userId)
        .then(tutores => {
          this.tutores = tutores;
        }).catch(error => {
          console.log("Erro ao procurar tutores: ", error)
        })
    },
    async Clientes() {
      try {
        const clientes = await ApiController.getClientes();
        await this.getTutorVinculado();

        const clienteSemVinculo = clientes.filter(cliente => {
          return !this.tutores.some(tutor => tutor.id === cliente.id);
        });

        this.clientes = clienteSemVinculo;

        // Restante do seu código...
      } catch (error) {
        console.log("Erro ao listar os clientes: ", error);
      }
    },


    async removerVinculo(clienteid, animalid) {
      Swal.fire({
        title: 'Motivo da exclusão',
        input: 'textarea',
        inputPlaceholder: 'Digite o motivo da exclusão...',
        showCancelButton: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancelar',
        inputAttributes: {
          required: 'required'
        },
        validationMessage: 'Por favor, digite um motivo.'
      }).then((result) => {
        if (result.isConfirmed) {
          const motivoExclusao = result.value;
          if (motivoExclusao) {
            ApiController.deletarVinculo(clienteid, animalid)
              .then((response) => {
                this.getTutorVinculado();
                this.Clientes();
              }).catch((error) => {
                console.error("Erro ao remover o vínculo: ", error);
              });

            Swal.fire("", "Tutor removido com sucesso", "success");
          }
        }
      });

    }
  },
  mounted() {
    this.getTutorVinculado();
    this.Clientes();

    $("#selectTutores").select2({
      placeholder: "Selecione o tutor",
      width: '100%'
    });

    $('#selectTutores').on('select2:select', (e) => {
      const tutor_id = e.params.data.id;
      const animal_id = this.userId

      ApiController.adicionarVinculo(tutor_id, animal_id)
        .then(response => {
          this.getTutorVinculado();
          this.Clientes();
          this.tutores = response.data;
          $("#selectTutores").val(null).trigger("change");
        })
        .catch(error => {
          console.log("Erro ao adicionar um vinculo: ", error);
        });
    });


  },
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

.btnTutores button {
  width: 30px;
  height: 30px;
  font-size: 16px;
  background-color: rgb(70, 68, 68);
  color: #fff;
  margin-left: 10px;
}

@media screen and (max-width: 750px) {
  #selectTutores.selectTutores+.select2-container .select2-selection {
    width: 100%;
  }

}
</style>

