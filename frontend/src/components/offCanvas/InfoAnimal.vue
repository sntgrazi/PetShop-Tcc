<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Pet</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div  class="informacoes">
        <span>{{ pet.nome_pet }}</span>

    </div>
  </div>
</div>
</template>

<script>

    export default {
        name: 'InfoAnimal',
        props: ['pet']
    }
</script>