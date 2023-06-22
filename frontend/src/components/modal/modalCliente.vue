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
            <form class="formModal" @submit.prevent="userId == false ? FormCadastro() : FormEdit()">
                <loading :loading="loading" />
                <div class="form-inputs" v-show="etapaAtual === 1">

                    <div class="inputCadastroCliente">
                        <div class="container-fluid">
                            <div class="col-sm-12">
                                <BaseInput :modelValue="cliente.nome"
                                    @update:modelValue="(newValue) => (cliente.nome = newValue)" :label="'Nome'"
                                    :idInput="'inputName'" />
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-6 col-sm-6">
                                            <BaseInput :modelValue="cliente.cpf" @update:modelValue="formatarCPF"
                                                :label="'Cpf'" :idInput="'inputCpf'" />
                                        </div>
                                        <div class="col-6 col-sm-6">
                                            <BaseInput :modelValue="cliente.telefone" @update:modelValue="formatarTelefone"
                                                :label="'Telefone'" :idInput="'inputTelefone'" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <BaseInput :modelValue="cliente.email"
                                    @update:modelValue="(newValue) => (cliente.email = newValue)" :label="'Email'"
                                    :idInput="'inputEmail'" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="proxima-etapa" @click="proximo">
                            Próximo
                        </button>
                    </div>
                </div>

                <div class="form-inputs" v-show="etapaAtual === 2">
                    <div class="inputCadastroCliente">
                        <div class="container-fluid">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-7 col-sm-7">
                                        <div class="colunaForm">
                                            <BaseInput :modelValue="cliente.cep"
                                                @update:modelValue="(newValue) => (cliente.cep = newValue)" :label="'Cep'"
                                                :idInput="'inputCep'" />

                                            <button type="button" class="btn-pesquisar" @click="procurarEndereço">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-5 col-sm-5">
                                        <BaseInput :modelValue="cliente.bairro"
                                            @update:modelValue="(newValue) => (cliente.bairro = newValue)" :label="'Bairro'"
                                            :idInput="'inputBairro'" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <BaseInput :modelValue="cliente.rua"
                                    @update:modelValue="(newValue) => (cliente.rua = newValue)" :label="'Rua'"
                                    :idInput="'inputRua'" />
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-7 col-sm-7">
                                        <BaseInput :modelValue="cliente.cidade"
                                            @update:modelValue="(newValue) => (cliente.cidade = newValue)" :label="'Cidade'"
                                            :idInput="'inputCidade'" />
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <BaseInput :modelValue="cliente.uf"
                                            @update:modelValue="(newValue) => (cliente.uf = newValue)" :label="'Uf'"
                                            :idInput="'inputUf'" />
                                    </div>
                                    <div class="col-2 col-sm-2">
                                        <BaseInput :modelValue="cliente.n_casa"
                                            @update:modelValue="(newValue) => (cliente.n_casa = newValue)" :label="'N°'"
                                            :idInput="'inputN_Casa'" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="proxima-etapa" @click="voltar">
                                <i class="fa-solid fa-arrow-left"></i> Voltar
                            </button>

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

import BaseInput from "../BaseInput/BaseInput.vue";
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import loading from '../Outros/loading.vue';

export default {
    name: 'ModalCliente',
    props: ['userId', 'toggle', 'tipo', 'icon', 'inputsCadastro', 'active'],
    components: {
        BaseInput,
        loading
    },
    emits: ["atualizarTabela"],
    data() {
        return {
            etapaAtual: 1,
            cliente: {},
            titulo: this.userId == false ? "Cadastrar Cliente" : "Editar Cliente",
            botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
            loading: true
        }
    },
    methods: {
        async FormCadastro() {
            try {

                const camposValidos = this.validarCampos();

                if (!camposValidos) {
                    return;
                }

                await ApiController.cadastrarCliente(this.cliente);
                Swal.fire("", "Cliente cadastrado com sucesso!", "success");
                this.$emit("atualizarTabela");
                this.toggle();
                this.cliente = {};
            } catch (error) {
                console.log(error);
            }
        },
        async FormEdit() {
            try {
                const camposValidos = this.validarCampos();

                if (!camposValidos) {
                    return;
                }
                await ApiController.editarCliente(this.userId, this.cliente);
                Swal.fire("", "Cliente atualizado com sucesso!", "success");
                this.$emit("atualizarTabela");
                this.toggle();
                this.cliente = {};
            } catch (error) {
                console.log(error);
            }
        },
        proximo() {
            this.etapaAtual = 2
        },
        voltar() {
            this.etapaAtual = 1
        },
        async buscarDadosCliente() {
            try {
                this.loading = true;
                const cliente = await ApiController.getClienteById(this.userId);
                this.cliente = cliente;
                this.endereco = cliente.endereco.split(",");
                this.cliente.cep = this.endereco[0];
                this.cliente.bairro = this.endereco[1];
                this.cliente.rua = this.endereco[2];
                this.cliente.cidade = this.endereco[3];
                this.cliente.uf = this.endereco[4];
                this.cliente.n_casa = this.endereco[5];

                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        async procurarEndereço() {
            const url = `https://viacep.com.br/ws/${this.cliente.cep}/json/`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                this.cliente.rua = data.logradouro;
                this.cliente.bairro = data.bairro;
                this.cliente.uf = data.uf;
                this.cliente.cidade = data.localidade;
            } catch (error) {
                console.error(error);
            }
        },

        validarCampos() {
            // Verificar se todos os campos obrigatórios estão preenchidos
            if (
                !this.cliente.nome ||
                !this.cliente.cpf ||
                !this.cliente.telefone ||
                !this.cliente.email ||
                !this.cliente.n_casa
            ) {
                Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(this.cliente.email)) {
                Swal.fire("", "Por favor, insira um endereço de e-mail válido.", "error");
                return; // Retorna para interromper o envio do formulário
            }

            // Verificar o formato correto do nome
            const regexNome = /^[A-Za-z\s]+$/;
            if (!regexNome.test(this.cliente.nome)) {
                Swal.fire("Erro", "Digite apenas letras e espaços no campo Nome.", "error");
                return false;
            }

            // ...

            return true;
        },


        formatarCPF(cpf) {
            // Remove qualquer caractere que não seja número
            const cleaned = cpf.replace(/\D/g, '');

            // Aplica a formatação XXX.XXX.XXX-XX
            const match = cleaned.match(/^(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2})$/);
            const formatted = !match
                ? cleaned
                : [match[1], match[2], match[3]].filter(Boolean).join('.') + (match[4] ? `-${match[4]}` : '');

            // Atualiza o valor do campo do CPF
            this.cliente.cpf = formatted;
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

            this.cliente.telefone = formatted;
        },
    },
    
    mounted() {  
        if (this.userId != false) {
            this.loading = true
            this.buscarDadosCliente()
          
        }  else {
            this.loading = false
        }
    }
}
</script>
