<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Produto</h5>
            <div class="btnAcaoOff">
                <button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(produto.id)">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(produto.id)">
                    <i class="fa-solid fa-trash"></i>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            {{ produto }}
        </div>
    </div>

</template>

<script>
export default{
    name: 'InfoProduto',
    props: ['produto', 'toggle'],
    methods: {
        abriModalEdit(id) {
            $('#offcanvasRight').offcanvas('hide');
            this.toggle('info', id)
        },
        excluir(id) {
            console.log(id)
            this.$emit("deletar", id)
        },
    }
}
</script>