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
            <loading :loading="loading" />
            <form class="formModal" @submit.prevent="userId == false ? FormCadastro() : FormEdit()">
                <div class="form-inputs" v-show="etapaAtual === 1">
                    <div class="inputAgendamento" v-if="inputsAgendamento">
                        <div class="container-fluid">
                            <div class="form-inputs">
                                <div class="col-md-12 col-sm-12">
                                    <div class="selectCampo">
                                        <label for="cliente">Cliente</label>
                                        <select v-model="agenda.cliente_id" id="select-cliente" class="selectCliente">
                                            <option v-for="cliente in clientes" :value="cliente.id" selected>
                                                {{ cliente.nome }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-md-12 col-sm-12">
                                    <div class="selectCampo">
                                        <label for="pet">Pet</label>
                                        <select v-model="agenda.animal_id" id="select-pet" class="selectPet">
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <div class="selectCampo">
                                                <label for="tutor">Funcionário Responsável</label>
                                                <select v-model="agenda.funcionario_id" id="select-funcionario">
                                                    <option v-for="funcionario in funcionarios" :value="funcionario.id">{{
                                                        funcionario.nome
                                                    }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-5">
                                            <div class="selectCampo">
                                                <label for="servico">Serviço</label>
                                                <select v-model="agenda.servico_id" id="select-servico">
                                                    <option v-for="servico in servicos" :value="servico.id">{{
                                                        servico.nome_servico }}
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
                </div>

                <div class="form-inputs" v-show="etapaAtual === 2">
                    <div class="inputsAgendamento" v-if="inputsAgendamento">
                        <div class="container-fluid">
                            <div class="col-md-12  col-sm-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <BaseInput v-model="agenda.data_inicio" :label="'Data Início'" :tipo="'date'" />
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <BaseInput v-model="agenda.data_termino" :label="'Data Término'"
                                            :idInput="'inputDataTermino'" :tipo="'date'" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-6 col-sm-6">
                                        <BaseInput v-model="agenda.hora_inicio" :label="'Hora Início'" :tipo="'time'"
                                            @input="updateDuration" />
                                    </div>
                                    <div class="col-6 col-sm-6">
                                        <BaseInput v-model="agenda.hora_termino" :label="'Hora Término'" :tipo="'time'"
                                            @input="updateDuration" />
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

import BaseInput from '../BaseInput/BaseInput.vue';
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";
import loading from '../Outros/loading.vue';

export default {
    name: "ModalAgenda",
    props: ['tipo', 'icon', 'inputsAgendamento', 'toggle', 'userId', 'active'],
    emits: ['atualizarCalendario'],
    components: {
        BaseInput,
        loading
    },
    data() {
        return {
            titulo: this.userId == false ? "Novo Agendamento" : "Editar Agendamento",
            botaoConfirm: this.userId == false ? "Agendar" : "Editar",
            agenda: {},
            servicos: [],
            clientes: [],
            funcionarios: [],
            etapaAtual: 1,
            loading: true
        }
    },
    methods: {
        proximo() {
            if (this.etapaAtual == 1) {
                this.etapaAtual = 2
            } else if (this.etapaAtual == 2) {
                this.etapaAtual = 3
            }
        },
        voltar() {
            if (this.etapaAtual == 2) {
                this.etapaAtual = 1
            } else if (this.etapaAtual == 3) {
                this.etapaAtual = 1
            }
        },
        updateDuration() {
            this.duration(); // Forçar a atualização da computed property duration
        },
        duration() {
            if (this.agenda.hora_inicio && this.agenda.hora_termino) {
                const [startHour, startMinute] = this.agenda.hora_inicio.split(":");
                const [endHour, endMinute] = this.agenda.hora_termino.split(":");
                let durationMinutes = (endHour - startHour) * 60 + (endMinute - startMinute);
                if (durationMinutes < 0) {
                    durationMinutes += 24 * 60; // Adicionar 24 horas em minutos
                }
                const hours = Math.floor(durationMinutes / 60);
                const minutes = durationMinutes % 60;
                let durationString = "";
                if (hours > 0) {
                    durationString += `${hours} hora${hours > 1 ? "s" : ""}`;
                }
                if (minutes > 0) {
                    durationString += ` ${minutes} minuto${minutes > 1 ? "s" : ""}`;
                }

                this.agenda.duracao = durationString.trim();
            } else {
                this.agenda.duracao = "";
            }
        },
        async buscarDadoAgendamento() {
            try {
                this.loading = true
                this.agenda = await ApiController.getOrdensById(this.userId);

                $("#select-cliente").select2();
                $("#select-cliente").val(this.agenda.cliente_id).trigger("change");

                await this.buscarPetVinculado(this.agenda.cliente_id);

                $("#select-pet").val(this.agenda.animal_id).trigger("change");


                $("#select-funcionario").select2();
                $("#select-funcionario").val(this.agenda.funcionario_id).trigger("change");

                $("#select-servico").select2();
                $("#select-servico").val(this.agenda.servico_id).trigger("change");

                this.agenda.data_inicio = new Date(this.agenda.data_inicio).toISOString().slice(0, 10)
                this.agenda.data_termino = new Date(this.agenda.data_termino).toISOString().slice(0, 10)

                this.agenda.hora_inicio = this.agenda.hora_inicio;
                this.agenda.hora_termino = this.agenda.hora_termino


                
              
                $("#select-cliente").on("change", async (e) => {
                    this.agenda.cliente_id = $("#select-cliente option:selected").val();
                    this.loading = true
                    await this.buscarPetVinculado(this.agenda.cliente_id)

                    this.loading = false
                });

                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        async buscarServicos() {
            try {
                this.servicos = await ApiController.getServicos();
            } catch (error) {
                console.log("Erro ao listar os Servicos: ", error);
            }
        },
        async buscarClientes() {
            try {
                this.loading = true
                this.clientes = await ApiController.buscarClienteTabela();
                this.loading = false
            } catch (error) {
                console.log("Erro ao listar os clientes: ", error)
            }
        },
        async buscarFuncionarios() {
            try {
                this.funcionarios = await ApiController.getFuncionarios();
            } catch (error) {
                console.log("Erro ao listar os funcionarios: ", error)
            }
        },
        async buscarPetVinculado(id) {
            try {

                this.pets = await ApiController.getpetVinculado(id);

                $("#select-pet").empty();
                $("#select-pet").append($("<option>", { value: "", text: "Selecione um Pet" }));

                this.pets.forEach((animal) => {
                    $("#select-pet").append(
                        $("<option>", {
                            value: animal.id,
                            text: animal.nome_pet,
                        })
                    );
                });

            } catch (error) {
                console.log("Erro ao listar os animais vinculados: ", error)
            }
        },
        async FormCadastro() {
            try {

                const camposValidos = this.validarCampos();

                if (!camposValidos) {
                    return;
                }

                await ApiController.inserirOrdem(this.agenda);
                Swal.fire("", "Agendamento feito com sucesso!", "success");
                this.$emit("atualizarCalendario");
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

                await ApiController.updateOrdem(this.userId, this.agenda);
                Swal.fire("", "Agendamento atualizado com sucesso!", "success");
                this.$emit("atualizarCalendario");
                this.toggle();
                this.agenda = {};
            } catch (error) {
                console.log(error);
            }
        },

        validarCampos() {
            // Verificar se todos os campos obrigatórios estão preenchidos
            if (
                !this.agenda.cliente_id ||
                !this.agenda.animal_id ||
                !this.agenda.funcionario_id ||
                !this.agenda.servico_id
            ) {
                Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
                return false;
            }
        },
    },
    mounted() {
        this.buscarServicos();
        this.buscarClientes();
        this.buscarFuncionarios();

        if (this.userId == false) {
       
            $("#select-servico").select2({
                placeholder: "Selecione um serviço",
                width: "100%",
            });

            $("#select-servico").on("change", (e) => {
                this.agenda.servico_id = $("#select-servico option:selected").val();
            });

            $("#select-cliente").select2({
                placeholder: "Selecione um cliente",
                width: "100%",
            });

            $("#select-cliente").on("change", async (e) => {

                this.agenda.cliente_id = $("#select-cliente option:selected").val();
                this.loading = true
                await this.buscarPetVinculado(this.agenda.cliente_id)

                this.loading = false
            });

            $("#select-pet").select2({
                placeholder: "Selecione um Pet",
                width: "100%",
            });

            $("#select-pet").on("change", (e) => {
                this.agenda.animal_id = $("#select-pet option:selected").val();
            });

            $("#select-funcionario").select2({
                placeholder: "Selecione um Funcionário",
                width: "100%"
            });

            $("#select-funcionario").on("change", (e) => {
                this.agenda.funcionario_id = $("#select-funcionario option:selected").val();
            });

        } else {
            this.buscarDadoAgendamento()
            
            

            $("#select-servico").select2({
                placeholder: "Selecione um serviço",
                width: "100%",
            });

            $("#select-cliente").select2({
                placeholder: "Selecione um cliente",
                width: "100%",
            });


            $("#select-pet").select2({
                placeholder: "Selecione um Pet",
                width: "100%",
            });

            $("#select-funcionario").select2({
                placeholder: "Selecione um Funcionário",
                width: "100%"
            });


        }
    }
}
</script>