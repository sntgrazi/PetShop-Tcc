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
                                <div class="col-md-7 col-sm-7">
                                    <BaseInput :modelValue="fornecedor.nome_fantasia"
                                        @update:modelValue="(newValue) => (fornecedor.nome_fantasia = newValue)"
                                        :label="'Nome'" :idInput="'inputName'" />
                                </div>
                                <div class="col-md-5 col-sm-5">
                                    <BaseInput :modelValue="fornecedor.cnpj" @update:modelValue="formatarCNPJ"
                                        :label="'Cnpj'" />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-5 ">
                                    <BaseInput :modelValue="fornecedor.telefone" @update:modelValue="formatarTelefone"
                                        :label="'Telefone'" :idInput="'inputName'" />
                                </div>
                                <div class="col-md-6 col-sm-7">
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

            const camposValidos = this.validarCampos();

            if (!camposValidos) {
                return;
            }
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

            const camposValidos = this.validarCampos();

            if (!camposValidos) {
                return;
            }
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
        },

        validarCampos() {
            // Verificar se todos os campos obrigatórios estão preenchidos
            if (
                !this.fornecedor.nome_fantasia ||
                !this.fornecedor.cnpj ||
                !this.fornecedor.telefone ||
                !this.fornecedor.email
            ) {
                Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(this.fornecedor.email)) {
                Swal.fire("", "Por favor, insira um endereço de e-mail válido.", "error");
                return; // Retorna para interromper o envio do formulário
            }

            // Verificar o formato correto do nome
            const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/;
            if (!regexNome.test(this.fornecedor.nome_fantasia)) {
                Swal.fire("Erro", "Digite apenas letras e espaços no campo Nome.", "error");
                return false;
            }

            // ...

            return true;
        },

        formatarTelefone(telefone) {
            const cleaned = telefone.replace(/\D/g, '');
            let formatted = '';

            if (cleaned.length === 11) {
                formatted = cleaned.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (cleaned.length === 10) {
                formatted = cleaned.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else {
                formatted = cleaned;
            }

            this.fornecedor.telefone = formatted;
        },

        formatarCNPJ(cnpj) {
            // Remove qualquer caractere que não seja número
            const cleaned = cnpj.replace(/\D/g, '');

            // Aplica a formatação XX.XXX.XXX/0001-XX
            const match = cleaned.match(/^(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})$/);
            const formatted = !match
                ? cleaned
                : [match[1], match[2], match[3]].filter(Boolean).join('.') +
                '/' +
                match[4] +
                (match[5] ? '-' + match[5] : '');

            // Atualiza o valor do campo do CNPJ
            this.fornecedor.cnpj = formatted;
        },
    },
    mounted() {
        if (this.userId) {
            this.buscarFornecedor();
        }

    }

}
</script>