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
                                            <BaseInput :modelValue="cliente.cpf"
                                                @update:modelValue="(newValue) => (cliente.cpf = newValue)" :label="'Cpf'"
                                                :idInput="'inputCpf'" />
                                        </div>
                                        <div class="col-6 col-sm-6">
                                            <BaseInput :modelValue="cliente.telefone"
                                                @update:modelValue="(newValue) => (cliente.telefone = newValue)"
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
