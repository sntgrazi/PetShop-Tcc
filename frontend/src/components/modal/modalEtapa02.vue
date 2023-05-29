<template>
    <div class="form-inputs" v-show="etapaAtual === 2">
        <div class="inputCadastroCliente" v-if="inputsCadastro">
            <div class="colunaForm">
                <BaseInput :modelValue="cliente.cep" @update:modelValue="(newValue) => (cliente.cep = newValue)"
                    :label="'Cep'" :idInput="'inputCep'" />

                <button type="button" class="btn-pesquisar" @click="procurarEndereço">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <BaseInput :modelValue="cliente.bairro" @update:modelValue="(newValue) => (cliente.bairro = newValue)"
                    :label="'Bairro'" :idInput="'inputBairro'" />
            </div>

            <div class="colunaForm">
                <BaseInput :modelValue="cliente.rua" @update:modelValue="(newValue) => (cliente.rua = newValue)"
                    :label="'Rua'" :idInput="'inputRua'" />
            </div>

            <div class="colunaForm">
                <BaseInput :modelValue="cliente.cidade" @update:modelValue="(newValue) => (cliente.cidade = newValue)"
                    :label="'Cidade'" :idInput="'inputCidade'" />

                <BaseInput :modelValue="cliente.uf" @update:modelValue="(newValue) => (cliente.uf = newValue)" :label="'Uf'"
                    :idInput="'inputUf'" />

                <BaseInput :modelValue="cliente.n_casa" @update:modelValue="(newValue) => (cliente.n_casa = newValue)"
                    :label="'N°'" :idInput="'inputN_Casa'" />
            </div>
        </div>

        <div class="inputsAnimais" v-if="inputsAnimais">
            <div class="colunaForm">
                <div class="selectCampo">
                    <label for="especie">Espécie</label>
                    <select v-model="animal.especie" id="select-especie" class="selectEspecie">
                        <option v-for="especie in especies" :value="especie.id" selected>
                            {{ especie.nome }}
                        </option>
                    </select>
                </div>

                <div class="selectCampo">
                    <label for="raca">Raça</label>
                    <select v-model="animal.raca" id="select-raca" class="selectRaca">
                        <option v-for="breed in breeds" :value="breed.name">
                            {{ breed.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="colunaForm">
                <BaseInput :modelValue="animal.pelagem" @update:modelValue="(newValue) => (animal.pelagem = newValue)"
                    :label="'Pelagem'" :idInput="'inputPelagem'" />

                <BaseInput :modelValue="animal.porte" @update:modelValue="(newValue) => (animal.porte = newValue)"
                    :label="'Porte'" :idInput="'inputPorte'" />
            </div>
        </div>

        <div class="inputsAgendamento" v-if="inputsAgendamento">
            <div class="calendario">
                <DatePicker v-model="dataSelecionada" @click="formatDate(dataSelecionada)" title-position="left" mode="date"
                    :select-attribute="selectAttribute" :attributes="attrs" />
            </div>
            <div class="colunaAgenda">
                <BaseInput v-model="agenda.horaInicio" :label="'Horário Início'" :tipo="'time'" @input="updateDuration" />
                <BaseInput v-model="agenda.horaTermino" :label="'Horário Término'" :tipo="'time'" @input="updateDuration" />
                <BaseInput :modelValue="duration" :label="'Duração'" readonly />
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

import "select2/dist/css/select2.css";
import "select2";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
import BaseInput from '../BaseInput.vue';
import { ref } from "vue";


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
            dataSelecionada: null,
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
            this.$forceUpdate(); // Forçar a atualização da computed property duration
        },
        formatDate(date) {
            if (date) {
                const day = date.getDate().toString().padStart(2, "0");
                const month = (date.getMonth() + 1).toString().padStart(2, "0");
                const year = date.getFullYear().toString();
                this.agenda.dataFormatada = `${year}-${month}-${day}`;
            } else {
                this.agenda.dataFormatada = null;
            }
        },
    },
    setup() {
        const date = ref(new Date());
        const selectAttribute = ref({ dot: true });
        const attrs = ref([
            {
                key: "today",
                highlight: {
                    fillMode: "solid",
                    color: "blue",
                },
                dates: new Date(),
            },
        ]);
        return {
            attrs,
            date,
            selectAttribute,
        };
    },
    computed: {
        duration() {
            if (this.agenda.horaInicio && this.agenda.horaTermino) {
                const [startHour, startMinute] = this.agenda.horaInicio.split(":");
                const [endHour, endMinute] = this.agenda.horaTermino.split(":");
                let durationMinutes =
                    (endHour - startHour) * 60 + (endMinute - startMinute);
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

                return durationString.trim();
            }
            return "";
        },
    },
}
</script>

<style>
.inputsAgendamento {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 25px;
}

.colunaAgenda {
    width: 200px;
}

.infoAgendamento {
    color: white;
}

@media screen and (max-width: 750px) {
    #select-especie.selectEspecie+.select2-container .select2-selection {
        width: 100%;
    }

    .inputsAgendamento {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .colunaAgenda {
        width: 80%;
    }

    .colunaAgenda>input[type="time"] {
        width: 100%;
    }
}
</style>