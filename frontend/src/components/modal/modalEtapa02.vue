<template>
    <div class="form-inputs" v-show="etapaAtual === 2">

        <div class="inputCadastroCliente" v-if="inputsCadastro">
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
                    <BaseInput :modelValue="cliente.rua" @update:modelValue="(newValue) => (cliente.rua = newValue)"
                        :label="'Rua'" :idInput="'inputRua'" />
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-7 col-sm-7">
                            <BaseInput :modelValue="cliente.cidade"
                                @update:modelValue="(newValue) => (cliente.cidade = newValue)" :label="'Cidade'"
                                :idInput="'inputCidade'" />
                        </div>
                        <div class="col-3 col-sm-3">
                            <BaseInput :modelValue="cliente.uf" @update:modelValue="(newValue) => (cliente.uf = newValue)"
                                :label="'Uf'" :idInput="'inputUf'" />
                        </div>
                        <div class="col-2 col-sm-2">
                            <BaseInput :modelValue="cliente.n_casa"
                                @update:modelValue="(newValue) => (cliente.n_casa = newValue)" :label="'N°'"
                                :idInput="'inputN_Casa'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inputsAnimais" v-if="inputsAnimais">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6  col-sm-6">
                            <div class="selectCampo">
                                <label for="especie">Espécie</label>
                                <select v-model="animal.especie" id="select-especie" class="selectEspecie">
                                    <option v-for="especie in especies" :value="especie.nome" selected>
                                        {{ especie.nome }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6  col-sm-6">
                            <div class="selectCampo">
                                <label for="raca">Raça</label>
                                <select v-model="animal.raca" id="select-raca" class="selectRaca">
                                    <option v-for="breed in breeds" :value="breed.noma_raca">
                                        {{ breed.noma_raca }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6  col-sm-6">
                            <div class="selectCampo">
                                <label for="pelagem">Pelagem</label>
                                <select v-model="animal.pelagem" id="select-pelagem" class="selectPelagem">
                                    <option v-for="pelagem in pelagens" :value="pelagem.tipo">
                                        {{ pelagem.tipo }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="selectCampo">
                                <label for="porte">Porte</label>
                                <select v-model="animal.porte" id="select-porte" class="selectPorte">
                                    <option v-for="porte in portes" :value="porte.tipo">
                                        {{ porte.tipo }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="inputsAgendamento" v-if="inputsAgendamento">
            <div class="container-fluid">
                <div class="col-md-12  col-sm-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <BaseInput v-model="agenda.data_inicio" :label="'Data Início'" :tipo="'date'" />
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <BaseInput v-model="agenda.data_termino" :label="'Data Término'" :idInput="'inputDataTermino'"
                                :tipo="'date'" />
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
                            <BaseInput v-model="agenda.hora_inicio" :label="'Hora Início'" :tipo="'time'"
                                @input="updateDuration" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" v-if="inputsAnimais || inputsCadastro || inputsAgendamento">
            <button type="button" class="proxima-etapa" @click="voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </button>

            <button v-if="inputsAnimais || inputsCadastro" class="confirm">
                {{ botaoConfirm }}
            </button>

            <button v-if="inputsAgendamento" type="button" class="proxima-etapa" @click="proximo">
                Proximo
            </button>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
import "select2/dist/css/select2.css";
import "select2";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
import BaseInput from '../BaseInput/BaseInput.vue';
import ApiController from "@/ApiController";

export default {
    name: 'modalEtapa02',
    components: {
        BaseInput,
        DatePicker
    },
    data() {
        return {
            especies: [
                { id: "dog", nome: "Cachorro" },
                { id: "cat", nome: "Gato" },
            ],
            portes: [],
            pelagens: []
        }
    },
    props: [
        "inputsCadastro",
        "inputsAnimais",
        "inputsAgendamento",
        "cliente",
        "animal",
        "agenda",
        "etapaAtual",
        "userId",
        "botaoConfirm",
        "breeds"
    ],
    methods: {
        voltar() {
            this.$emit('voltarEtapa')
        },
        proximo() {
            this.$emit('proximaEtapa')
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
        async buscarPortes() {
            try {
                const portes = await ApiController.buscarPortes();
                this.portes = portes
            } catch (error) {
                console.log('Erro ao tentar buscas os portes: ', error)
            }
        },
        async buscarPelagens() {
            try {
                const pelagens = await ApiController.buscarPelagens();
                this.pelagens = pelagens
            } catch (error) {
                console.log('Erro ao tentar buscas as pelagens: ', error)
            }
        },
        
    },
    mounted() {
        this.buscarPortes();
        this.buscarPelagens();

        if (this.userId != false) {
            $("#select-porte").select2({
                width: "100%",
            });

            $("#select-porte").on("change", (e) => {
                this.animal.sexo = $("#select-sexo option:selected").val();
            });

            $("#select-pelagem").select2({
                width: "100%",
            });

            $("#select-pelagem").on("change", (e) => {
                this.animal.pelagem = $("#select-pelagem option:selected").val();
            });
        }
    }

}
</script>

<style>
#idDuracao {
    display: none;
}

.inputsAgendamento {
    display: flex;
    flex-direction: column;
}

.infoAgendamento {
    color: white;
}

@media screen and (max-width: 750px) {
    #select-especie.selectEspecie+.select2-container .select2-selection {
        width: 100%;
    }


}
</style>