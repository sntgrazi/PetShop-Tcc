<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Pet</h5>
      <div class="btnAcaoOff">
        <button class="btnEditarOffCanvas" id="btn-tutores" v-if="this.tipo == 'pet'" @click="toggle('tutores', pet.id)">
          <i style="color: rgb(18, 99, 180);" class="fa-solid fa-user"></i>
        </button>
        <button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(pet.id)">
          <i style="color: rgb(52, 136, 149);" class="fa-solid fa-pen"></i>
        </button>
        <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(pet.id)">
          <i style="color: red;" class="fa-solid fa-trash"></i>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
    <div class="offcanvas-body">
      <div class="informacoes">
        <h4 style="color: #1e90ff;" class="mb-4">Dados do Pet</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="mb-3">
              <h6>Pet</h6>
              <p>{{ pet.nome_pet }}</p>
            </div>
          </div>
          <div class="col-md-12">
            <div class="mb-3">
              <h6>Data de Nascimento</h6>
              <p>{{ pet.data_nascimento }}</p>
            </div>
            <div class="mb-3">
              <h6>Sexo</h6>
              <p>{{ pet.sexo }}</p>
            </div>
          </div>
          <div class="mb-duo">
            <div class="linhaEnd">
              <h6>Altura</h6>
              <p>{{ pet.altura }} cm</p>
            </div>
            <div class="linhaen">
              <h6>Peso</h6>
              <p>{{ pet.peso }} kg</p>
            </div>
          </div>
        </div>
        <hr class="mb-4">

        <h4 style="color: #1e90ff;" class="mt-4 mb-4">Especificações</h4>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <h6>Espécie</h6>
              <p>{{ pet.especie }}</p>
            </div>
            <div class="mb-3">
              <h6>Raça</h6>
              <p>{{ pet.raca }}</p>
            </div>
            <div class="mb-3">
              <h6>Pelagem</h6>
              <p>{{ pet.pelagem }}</p>
            </div>
            <div class="mb-3">
              <h6>Porte</h6>
              <p>{{ pet.porte }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'InfoAnimal',
  props: ["pet", "toggle", "tipo"],
  methods: {
    excluir(id) {
      this.$emit("deletar", id)
    },
    abriModalEdit(id) {
      $('#offcanvasRight').offcanvas('hide');
      this.toggle('info', id)
    },
  }
}
</script>