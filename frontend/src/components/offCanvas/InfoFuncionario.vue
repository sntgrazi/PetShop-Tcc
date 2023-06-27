<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 style="color: #1e90ff;" class="offcanvas-title" id="offcanvasRightLabel">Funcionario</h5>
            <div class="btnAcaoOff">
                <button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(funcionario.id)">
                    <i style="color: rgb(52, 136, 149);" class="fa-solid fa-pen"></i>
                </button>
                <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(funcionario.id)">
                    <i style="color: red;" class="fa-solid fa-trash"></i>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="informacoes">
                <h4 style="color: #1e90ff;" class="mb-4">Dados Pessoais</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <h6>Nome</h6>
                            <p>{{ funcionario.nome }}</p>
                        </div>
                        <div class="mb-3">
                            <h6>Cpf</h6>
                            <p>{{ funcionario.cpf }}</p>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h6>Telefone</h6>
                                <p>{{ funcionario.telefone }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Email</h6>
                                <p>{{ funcionario.email }}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">

                    <h4 style="color: #1e90ff;" class="mt-4 mb-4">Endereço</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Cep</h6>
                                <p>{{ funcionario.cep }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Bairro</h6>
                                <p>{{ funcionario.bairro }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Nº</h6>
                                <p>{{ funcionario.n_casa }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Uf</h6>
                                <p>{{ funcionario.uf }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Cidade</h6>
                                <p>{{ funcionario.cidade }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Rua</h6>
                                <p>{{ funcionario.rua }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'InfoFuncionario',
    props: ['funcionario', 'toggle'],
    data() {
        return {
        endereco: []
     }
    },
    methods: {
        abriModalEdit(id) {
            $('#offcanvasRight').offcanvas('hide');
            this.toggle('info', id)
        },
        excluir(id) {
            this.$emit("deletar", id)
        },
    }

}
</script>