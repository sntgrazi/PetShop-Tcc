<template>
    <div class="custom-form-overlay"></div>
    <div class="custom-modal" :class="{ active: active }">
        <div class="modal-header">
            <div class="titulo-modal">
                <i :class="['fa regular', icon]"></i>
                <h3>{{ titulo }}</h3>
            </div>
            <button type="button" @click="() => toggle()" id="close-modal" class="close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="modal-body">
            
        </div>
    </div>
</template>

<script>


export default {
    name: 'modalForncedor',
    props: ['icon', 'userId', 'toggle', 'tipo', 'active'],
    data() {
        return {
            titulo: this.userId == false ? "Cadastrar Fornecedor" : "Editar Fornecedor",
            botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
            loading: true
        }
    }

}
</script>