<template>
    <div class="form-inputs" v-show="etapaAtual === 1">
        <loading :loading="loading" />
        <div class="inputCadastroCliente" v-if="inputsCadastro">
            <div class="container-fluid">

                <div class="col-sm-12">
                    <BaseInput :modelValue="cliente.nome" @update:modelValue="(newValue) => (cliente.nome = newValue)"
                        :label="'Nome'" :idInput="'inputName'" />
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
                                    @update:modelValue="(newValue) => (cliente.telefone = newValue)" :label="'Telefone'"
                                    :idInput="'inputTelefone'" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <BaseInput :modelValue="cliente.email" @update:modelValue="(newValue) => (cliente.email = newValue)"
                        :label="'Email'" :idInput="'inputEmail'" />
                </div>
            </div>
        </div>

        <div class="inputsAnimais" v-if="inputsAnimais">
            <div class="container-fluid">
            <div class="col-sm-12">
                <div v-if="!userId">
                    <label for="tutor">Tutor</label>
                    <select v-model="animal.tutor_id" id="select-tutor" class="selectTutor">
                        <option v-for="tutor in tutores" :value="tutor.id" selected>
                            {{ tutor.nome }}
                        </option>
                    </select>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <BaseInput :modelValue="animal.nome_pet"
                            @update:modelValue="(newValue) => (animal.nome_pet = newValue)" :label="'Pet'"
                            :idInput="'inputPet'" />
                    </div>
                    <div class="col-6 col-sm-4">
                        <BaseInput :modelValue="animal.data_nascimento" @update:modelValue="(newValue) => (animal.data_nascimento = newValue)
                            " :label="'Nascimento'" :idInput="'inputDataNascimento'" :tipo="'date'" />
                    </div>
                    <div class="col-6 col-sm-2">
                        <BaseInput :modelValue="animal.sexo" @update:modelValue="(newValue) => (animal.sexo = newValue)"
                            :label="'Sexo'" :idInput="'inputSexo'" />
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <BaseInput :modelValue="animal.altura" @update:modelValue="(newValue) => (animal.altura = newValue)"
                            :label="'Altura'" :idInput="'inputAltura'" />

                    </div>
                    <div class="col-6 col-sm-6">
                        <BaseInput :modelValue="animal.peso" @update:modelValue="(newValue) => (animal.peso = newValue)"
                            :label="'Peso'" :idInput="'inputPeso'" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="inputAgendamento" v-if="inputsAgendamento">
        <div class="container-fluid">
         <div class="form-inputs">
            <div class="col-md-12 col-sm-12">
                <div class="selectCampo">
                    <label for="cliente">Cliente</label>
                    <select v-model="agenda.cliente_id" id="select-cliente" class="selectCliente">
                        <option v-for="cliente in clientesTabela" :value="cliente.id" selected>
                            {{ cliente.nome }}
                        </option>
                    </select>
                </div>
            </div>
            <div class=" col-md-12 col-sm-12">
                <div class="selectCampo">
                    <label for="pet">Pet</label>
                    <select v-model="agenda.pet" id="select-pet" class="selectPet">
                    </select>
                </div>
            </div>


            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-12 col-sm-7">
                        <div class="selectCampo">
                            <label for="tutor">Funcionário Responsável</label>
                            <select v-model="agenda.funcionario" id="select-funcionario">
                                <option v-for="funcionario in funcionarios" :value="funcionario.id">{{ funcionario.nome
                                }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-5">
                        <div class="selectCampo">
                            <label for="servico">Serviço</label>
                            <select v-model="agenda.servico" id="select-servico">
                                <option v-for="servico in servicos" :value="servico.id">{{ servico.nome_servico }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal-footer" v-if="inputsAnimais || inputsCadastro || inputsAgendamento">
        <button type="button" class="proxima-etapa" @click="proximo">
            Próximo
        </button>
    </div>
</div></template>

<script>
import loading from "../Outros/loading.vue";
import BaseInput from "../BaseInput/BaseInput.vue";
import "select2/dist/css/select2.css";
import "select2";
import ApiController from "@/ApiController";
import $ from "jquery";


export default {
    name: 'modalEtapa01',
    components: {
        BaseInput,
        loading
    },
    props: [
        "inputsCadastro",
        "inputsAnimais",
        "inputsAgendamento",
        "cliente",
        "animal",
        "agenda",
        "etapaAtual",
        "userId"
    ],
    data() {
        return {
            tutores: [],
            servicos: [],
            pets: [],
            clientesTabela: [],
            funcionarios: [],
            loading: true
        }
    },
    methods: {
        async Clientes() {
            try {
                this.loading = true
                this.tutores = await ApiController.getClientes();

                this.loading = false
            } catch (error) {
                console.log("Erro ao listar os clientes: ", error);
            }
        },
        async getServicos() {
            try {
                this.servicos = await ApiController.getServicos();
            } catch (error) {
                console.log("Erro ao listar os Servicos: ", error);
            }
        },
        async buscarClienteTabela() {
            try {

                this.clientesTabela = await ApiController.buscarClienteTabela();

            } catch (error) {
                console.log("Erro ao listar os clientes: ", error)
            }
        },

        async getFuncionarios() {
            try {
                this.funcionarios = await ApiController.getFuncionarios();
            } catch (error) {
                console.log("Erro ao listar os funcionarios: ", error)
            }
        },

        proximo() {
            this.$emit('proximaEtapa')
        },

    },
    mounted() {
        this.loading = true
        this.Clientes();
        this.getServicos();
        this.buscarClienteTabela();
        this.getFuncionarios();


    },


}
</script>