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
            <form class="formModal" @submit.prevent="userId == false ? FormCadastro() : FormEdit()"
                enctype="multipart/form-data">
                <div class="form-inputs">
                    <div class="container-fluid">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-7 col-sm-7 ">
                                    <BaseInput :modelValue="fornecedor.nome_fantasia"
                                        @update:modelValue="(newValue) => (fornecedor.nome_fantasia = newValue)"
                                        :label="'Nome'" :idInput="'inputName'" />
                                </div>
                                <div class="col-5 col-sm-5">
                                    <BaseInput :modelValue="fornecedor.cnpj" @update:modelValue="(newValue) => (fornecedor.cnpj = newValue)
                                        " :label="'Cnpj'" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-5 col-sm-5 ">
                                    <BaseInput :modelValue="fornecedor.telefone" @update:modelValue="(newValue) => (fornecedor.telefone = newValue)
                                        " :label="'Telefone'" :idInput="'inputName'" />
                                </div>
                                <div class="col-7 col-sm-7">
                                    <BaseInput :modelValue="fornecedor.email" @update:modelValue="(newValue) => (fornecedor.email = newValue)
                                        " :label="'Email'" />
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="confirm">
                                {{ botaoConfirm }}
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import ApiController from '@/ApiController';
import BaseInput from '../BaseInput/BaseInput.vue';
import Swal from 'sweetalert2';

export default {
    name: 'modalForncedor',
    props: ['active', 'userId', 'toggle', 'tipo', 'icon'],
    emits: ['atualizarTabela'],
    components: {
        BaseInput,
    },
    data() {
        return {
            titulo: this.userId == false ? "Cadastrar Fornecedor" : "Editar Fornecedor",
            botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
            loading: true,
            fornecedor: {}
        }
    },
    methods: {
        async FormCadastro() {
            try {
                await ApiController.cadastrarFornecedor(this.fornecedor);
                Swal.fire("", "Fornecedor cadastrado com sucesso!", "success");
                this.$emit("atualizarTabela");
                this.toggle();
                this.fornecedor = {};
            } catch (error) {
                console.log(error)
            }
        },
        async FormEdit() {
            try {
                await ApiController.atualizarFornecedor(this.userId, this.fornecedor);
                Swal.fire("", "Fornecedor atualizado com sucesso!", "success");
                this.$emit("atualizarTabela");
                this.toggle();
                this.fornecedor = {};
            } catch (error) {
                console.log(error);
            }
        },
        async buscarFornecedor() {
            try {
                this.loading = true;
                const fornecedor = await ApiController.getFornecedorById(this.userId);
                this.fornecedor = fornecedor;

                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        }
    },
    mounted(){

        if (this.userId){
            this.buscarFornecedor();
        }
    }
}
</script>