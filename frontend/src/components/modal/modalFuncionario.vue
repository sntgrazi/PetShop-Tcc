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
                <div class="form-inputs" v-show="etapaAtual === 1">
                    <div class="inputCadastroCliente">
                        <div class="container-fluid">
                            <div class="col-sm-12">
                                <BaseInput :modelValue="funcionario.nome"
                                    @update:modelValue="(newValue) => (funcionario.nome = newValue)" :label="'Nome'"
                                    :idInput="'inputName'" />
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-7 col-sm-7">
                                            <BaseInput :modelValue="funcionario.cpf"
                                                @update:modelValue="(newValue) => (funcionario.cpf = newValue)"
                                                :label="'Cpf'" :idInput="'inputCpf'" />
                                        </div>
                                        <div class="col-5 col-sm-5">
                                            <BaseInput :modelValue="funcionario.telefone"
                                                @update:modelValue="(newValue) => (funcionario.telefone = newValue)"
                                                :label="'Telefone'" :idInput="'inputTelefone'" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-7 col-sm-7">
                                        <BaseInput :modelValue="funcionario.email"
                                            @update:modelValue="(newValue) => (funcionario.email = newValue)"
                                            :label="'Email'" :idInput="'inputEmail'" />
                                    </div>
                                    <div class="col-5 col-sm-5">
                                        <div class="selectCampo">
                                            <label for="cargo">Cargo</label>
                                            <select v-model="funcionario.cargo_id" id="select-cargo"
                                                class="selectsForm selectCargo">
                                                <option v-for="cargo in cargos" :value="cargo.id">
                                                    {{ cargo.nome_cargo }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
                                            <BaseInput :modelValue="funcionario.cep"
                                                @update:modelValue="(newValue) => (funcionario.cep = newValue)" :label="'Cep'"
                                                :idInput="'inputCep'" />

                                            <button type="button" class="btn-pesquisar" @click="procurarEndereço">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-5 col-sm-5">
                                        <BaseInput :modelValue="funcionario.bairro"
                                            @update:modelValue="(newValue) => (funcionario.bairro = newValue)" :label="'Bairro'"
                                            :idInput="'inputBairro'" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <BaseInput :modelValue="funcionario.rua"
                                    @update:modelValue="(newValue) => (funcionario.rua = newValue)" :label="'Rua'"
                                    :idInput="'inputRua'" />
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-7 col-sm-7">
                                        <BaseInput :modelValue="funcionario.cidade"
                                            @update:modelValue="(newValue) => (funcionario.cidade = newValue)" :label="'Cidade'"
                                            :idInput="'inputCidade'" />
                                    </div>
                                    <div class="col-3 col-sm-3">
                                        <BaseInput :modelValue="funcionario.uf"
                                            @update:modelValue="(newValue) => (funcionario.uf = newValue)" :label="'Uf'"
                                            :idInput="'inputUf'" />
                                    </div>
                                    <div class="col-2 col-sm-2">
                                        <BaseInput :modelValue="funcionario.n_casa"
                                            @update:modelValue="(newValue) => (funcionario.n_casa = newValue)" :label="'N°'"
                                            :idInput="'inputN_Casa'" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="proxima-etapa" @click="voltar">
                                voltar
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
import BaseInput from '../BaseInput/BaseInput.vue'
import "select2/dist/css/select2.css";
import "select2";
import $ from "jquery";
import ApiController from '@/ApiController';

export default {
    name: 'modalFuncionario',
    props: ['toggle', 'icon', 'active', 'userId'],
    components: {
        BaseInput
    },
    data() {
        return {
            titulo: this.userId == false ? "Cadastrar Funcionário" : "Editar Funcionário",
            botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
            etapaAtual: 1,
            funcionario: [],
            cargos: []
        }
    },
    methods: {
        proximo() {
            this.etapaAtual = 2
        },
        voltar() {
            this.etapaAtual = 1
        },
        async buscarCargos() {
            try {
                this.cargos = await ApiController.getAllCargos();
            } catch (error) {
                console.log("Erro ao listar os cargos: ", error)
            }
        },
        async procurarEndereço() {
            const url = `https://viacep.com.br/ws/${this.funcionario.cep}/json/`;
            try {
                const response = await fetch(url);
                const data = await response.json();
                this.funcionario.rua = data.logradouro;
                this.funcionario.bairro = data.bairro;
                this.funcionario.uf = data.uf;
                this.funcionario.cidade = data.localidade;
            } catch (error) {
                console.error(error);
            }
        },
        FormCadastro(){
            console.log(this.funcionario)
        }

    },
    mounted() {
        this.buscarCargos();

        $("#select-cargo").select2({
            placeholder: "Selecione o cargo",
            width: "100%",
        });

        $("#select-cargo").on("change", (e) => {
        // Obtém a raça selecionada
        this.funcionario.cargo_id = $("#select-cargo option:selected").val();
      });
    }
}
</script>