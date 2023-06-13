<template>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Cliente</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div  class="informacoes">
        <span>{{ cliente.nome }}</span>
        <span>{{ cliente.cpf }}</span>
        <span> {{ cliente.telefone }}</span>
        <span> {{ cliente.email }}</span>
        <span> {{ cliente.endereco }}</span>
    </div>
  </div>
</div>
</template>

<script>
    export default{
        name: 'infoCliente',
        props: ['cliente']
    }

</script>