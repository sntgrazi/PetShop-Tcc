<template>
    <div class="form-inputs" v-show="etapaAtual === 1">
        <div class="inputCadastroCliente" v-if="inputsCadastro">
            <BaseInput :modelValue="cliente.nome" @update:modelValue="(newValue) => (cliente.nome = newValue)"
                :label="'Nome'" :idInput="'inputName'" />

            <div class="colunaForm">
                <BaseInput :modelValue="cliente.cpf" @update:modelValue="(newValue) => (cliente.cpf = newValue)"
                    :label="'Cpf'" :idInput="'inputCpf'" />

                <BaseInput :modelValue="cliente.telefone" @update:modelValue="(newValue) => (cliente.telefone = newValue)"
                    :label="'Telefone'" :idInput="'inputTelefone'" />
            </div>

            <div class="colunaForm">
                <BaseInput :modelValue="cliente.email" @update:modelValue="(newValue) => (cliente.email = newValue)"
                    :label="'Email'" :idInput="'inputEmail'" />
            </div>
        </div>

        <div class="inputsAnimais" v-if="inputsAnimais">
            <div class="colunaForm">
                <div class="selectCampo" v-if="!userId">
                    <label for="tutor">Tutor</label>
                    <select v-model="animal.tutor_id" id="select-tutor" class="selectTutor">
                        <option v-for="tutor in tutores" :value="tutor.id" selected>
                            {{ tutor.nome }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="colunaForm">
                <BaseInput :modelValue="animal.nome_pet" @update:modelValue="(newValue) => (animal.nome_pet = newValue)"
                    :label="'Pet'" :idInput="'inputPet'" />

                <BaseInput :modelValue="animal.data_nascimento" @update:modelValue="(newValue) => (animal.data_nascimento = newValue)
                    " :label="'Nascimento'" :idInput="'inputDataNascimento'" />

                <BaseInput :modelValue="animal.sexo" @update:modelValue="(newValue) => (animal.sexo = newValue)"
                    :label="'Sexo'" :idInput="'inputSexo'" />
            </div>

            <div class="colunaForm">
                <BaseInput :modelValue="animal.altura" @update:modelValue="(newValue) => (animal.altura = newValue)"
                    :label="'Altura'" :idInput="'inputAltura'" />

                <BaseInput :modelValue="animal.peso" @update:modelValue="(newValue) => (animal.peso = newValue)"
                    :label="'Peso'" :idInput="'inputPeso'" />
            </div>
        </div>

        <div class="inputAgendamento" v-if="inputsAgendamento">
            <div class="form-inputs">
                <div class="selectCampo">
                    <label for="cliente">Cliente</label>
                    <select v-model="agenda.cliente" id="select-cliente" class="selectCliente">
                        <option v-for="cliente in clientesTabela" :value="cliente.id" selected>
                            {{ cliente.nome }}
                        </option>
                    </select>
                </div>
                <div class="selectCampo">
                    <label for="pet">Pet</label>
                    <select v-model="agenda.nomePet" id="select-pet" class="selectPet">

                    </select>
                </div>
                <div class="colunaForm">
                    <BaseInput :modelValue="agenda.nomeColaborador" @update:modelValue="(newValue) => (agenda.nomeColaborador = newValue)
                        " :label="'Funcionário Responsavel'" :idInput="'inputPorte'" />

                    <div class="selectCampo">
                        <label for="tutor">Serviço</label>
                        <select v-model="agenda.servico" id="select-servico">
                            <option v-for="servico in servicos" :value="servico.nome_servico">{{ servico.nome_servico }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" v-if="inputsAnimais || inputsCadastro || inputsAgendamento">
            <button type="button" class="proxima-etapa" @click="proximo">
                Próximo
            </button>
        </div>
    </div>
</template>

<script>

import BaseInput from "../BaseInput.vue";
import "select2/dist/css/select2.css";
import "select2";
import ApiController from "@/ApiController";
import $ from "jquery";


export default {
    name: 'modalEtapa01',
    components: {
        BaseInput,
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
            clientesTabela: []
        }
    },
    methods: {
        async Clientes() {
            try {
                this.tutores = await ApiController.getClientes();
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
        async getPetVinculado(id) {
            try {

                this.pets = await ApiController.getpetVinculado(id);
                console.log(this.agenda.cliente)
                $("#select-pet").empty();
                $("#select-pet").append($("<option>", { value: "", text: "Selecione um Pet" }));

                this.pets.forEach((pet) => {
                    $("#select-pet").append(
                        $("<option>", {
                            value: pet.id,
                            text: pet.nome_pet,
                        })
                    );
                });
            } catch (error) {
                console.log("Erro ao listar os animais vinculados: ", error)
            }
        },
        proximo() {
            this.$emit('proximaEtapa')
        }
    },
    mounted() {
        this.Clientes();
        this.getServicos();
        this.buscarClienteTabela();

        $("#select-tutor").select2({
            placeholder: "Selecione um Tutor",
            width: "100%",
        });

        $("#select-tutor").on("change", (e) => {
            // Obtém a raça selecionada
            this.animal.tutor_id = $("#select-tutor option:selected").val();
        });

        $("#select-servico").select2({
            placeholder: "Selecione um serviço",
            width: "100%",
        });

        $("#select-servico").on("change", (e) => {
            // Obtém a raça selecionada
            this.agenda.servico = $("#select-servico option:selected").val();
        });

        $("#select-cliente").select2({
            placeholder: "Selecione um cliente",
            width: "100%",
        });

        $("#select-cliente").on("change", (e) => {
            // Obtém a raça selecionada
            this.agenda.cliente = $("#select-cliente option:selected").val();

            this.getPetVinculado(this.agenda.cliente)

        });


        $("#select-pet").select2({
            placeholder: "Selecione um Pet",
            width: "100%",
        });

        $("#select-pet").on("change", (e) => {
            // Obtém a raça selecionada
            this.agenda.nomePet = $("#select-pet option:selected").val();
        });
    },

}
</script>