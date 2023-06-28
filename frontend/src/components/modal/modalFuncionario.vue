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
                            <div class="col-md-12 col-sm-12">
                                <BaseInput :modelValue="funcionario.nome"
                                    @update:modelValue="(newValue) => (funcionario.nome = newValue)" :label="'Nome'"
                                    :idInput="'inputName'" />
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-7">
                                            <BaseInput :modelValue="funcionario.cpf" @update:modelValue="formatarCPF"
                                                :label="'Cpf'" :idInput="'inputCpf'" />
                                        </div>
                                        <div class="col-md-6 col-sm-5">
                                            <BaseInput :modelValue="funcionario.telefone"
                                                @update:modelValue="formatarTelefone" :label="'Telefone'"
                                                :idInput="'inputTelefone'" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-7">
                                        <BaseInput :modelValue="funcionario.email"
                                            @update:modelValue="(newValue) => (funcionario.email = newValue)"
                                            :label="'Email'" :idInput="'inputEmail'" />
                                    </div>
                                    <div class="col-md-6 col-sm-5">
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
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-7">
                                        <div class="colunaForm">
                                            <BaseInput :modelValue="funcionario.cep"
                                                @update:modelValue="(newValue) => (funcionario.cep = newValue)"
                                                :label="'Cep'" :idInput="'inputCep'" />

                                            <button type="button" class="btn-pesquisar" @click="procurarEndereço">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-5">
                                        <BaseInput :modelValue="funcionario.bairro"
                                            @update:modelValue="(newValue) => (funcionario.bairro = newValue)"
                                            :label="'Bairro'" :idInput="'inputBairro'" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <BaseInput :modelValue="funcionario.rua"
                                    @update:modelValue="(newValue) => (funcionario.rua = newValue)" :label="'Rua'"
                                    :idInput="'inputRua'" />
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-12 col-sm-7">
                                        <BaseInput :modelValue="funcionario.cidade"
                                            @update:modelValue="(newValue) => (funcionario.cidade = newValue)"
                                            :label="'Cidade'" :idInput="'inputCidade'" />
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <BaseInput :modelValue="funcionario.uf"
                                            @update:modelValue="(newValue) => (funcionario.uf = newValue)" :label="'UF'"
                                            :idInput="'inputUf'" />
                                    </div>
                                    <div class="col-6 col-sm-2">
                                        <BaseInput :modelValue="funcionario.n_casa"
                                            @update:modelValue="(newValue) => (funcionario.n_casa = newValue)" :label="'N°'"
                                            :idInput="'inputN_Casa'" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="proxima-etapa" @click="voltar">
                                Voltar
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
import Swal from 'sweetalert2';
import loading from '../Outros/loading.vue';

export default {
    name: 'modalFuncionario',
    props: ['toggle', 'icon', 'active', 'userId'],
    components: {
        BaseInput,
        loading
    },
    emits: ['atualizarTabela'],
    data() {
        return {
            titulo: this.userId == false ? "Cadastrar Funcionário" : "Editar Funcionário",
            botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
            etapaAtual: 1,
            funcionario: {},
            cargos: [],
            loading: true
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
                this.loading = true
                this.cargos = await ApiController.getAllCargos();
                this.loading = false
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
        async buscarDadosFuncionario() {
            try {
                this.loading = true
                const funcionario = await ApiController.getFuncionarioById(this.userId);
                this.funcionario = funcionario;

                this.endereco = funcionario.endereco.split(",");
                this.funcionario.cep = this.endereco[0];
                this.funcionario.bairro = this.endereco[1];
                this.funcionario.rua = this.endereco[2];
                this.funcionario.cidade = this.endereco[3];
                this.funcionario.uf = this.endereco[4];
                this.funcionario.n_casa = this.endereco[5];


                $("#select-cargo").select2();
                $("#select-cargo").val(funcionario.cargo_id).trigger("change");

                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        async FormCadastro() {
            try {

                const camposValidos = this.validarCampos();

                if (!camposValidos) {
                    return;
                }

                this.loading = true
                await ApiController.cadastrarFuncionario(this.funcionario);

                Swal.fire("", "Funcionário cadastrado com sucesso!", "success");
                this.$emit("atualizarTabela");
                this.toggle();
                this.funcionario = {};
                this.loading = false
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

                this.loading = true
                await ApiController.editarFuncionario(this.userId, this.funcionario);

                Swal.fire("", "Funcionário atualizado com sucesso!", "success");
                this.$emit("atualizarTabela");
                this.toggle();
                this.funcionario = {};
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },

        validarCampos() {
            // Verificar se todos os campos obrigatórios estão preenchidos
            if (
                !this.funcionario.nome ||
                !this.funcionario.cpf ||
                !this.funcionario.telefone ||
                !this.funcionario.email ||
                !this.funcionario.n_casa
            ) {
                Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(this.funcionario.email)) {
                Swal.fire("", "Por favor, insira um endereço de e-mail válido.", "error");
                return; // Retorna para interromper o envio do formulário
            }

            // Verificar o formato correto do nome
            const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/;
            if (!regexNome.test(this.funcionario.nome)) {
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
            this.funcionario.cpf = formatted;
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

            this.funcionario.telefone = formatted;
        },
    },
    mounted() {
        this.buscarCargos();

        if (this.userId == false) {
            $("#select-cargo").select2({
                placeholder: "Selecione o cargo",
                width: "100%",
            });

            $("#select-cargo").on("change", (e) => {
                this.funcionario.cargo_id = $("#select-cargo option:selected").val();
            });

        } else {
            this.buscarDadosFuncionario();

            $("#select-cargo").select2({
                placeholder: "Selecione o cargo",
                width: "100%",
            });
        }
    }
}
</script>