<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Pet</h5>
      <div class="btnAcaoOff">
        <button class="btnEditarOffCanvas" id="btn-tutores" v-if="this.tipo == 'pet'" @click="toggle('tutores', pet.id)">
          <i class="fa-solid fa-user"></i>
        </button>
        <button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(pet.id)">
          <i class="fa-solid fa-pen"></i>
        </button>
        <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(pet.id)">
          <i class="fa-solid fa-trash"></i>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
    <div class="offcanvas-body">
      <div class="informacoes">
        <span>{{ pet.nome_pet }}</span>

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