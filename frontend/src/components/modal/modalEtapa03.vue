<template>
    <div class="form-inputs" v-if="inputsAgendamento" v-show="etapaAtual === 3">
        <div class="infoAgendamento">
            <p>Resumo do Agendamento</p>
            <br />
            <span> Cliente: {{ agenda.cliente }}</span> <br />
            <span> Pet: {{ agenda.nomePet }}</span> <br />
            <span> Data: {{ agenda.data }}</span> <br />
            <span>
                Hora: {{ agenda.horaInicio }} às {{ agenda.horaTermino }}</span>
            <br />
            <span> Duração Aprox: {{ agenda.duracao }} </span> <br />
            <span> Servico: {{ agenda.servico }} </span> <br />
            <span> Profissional Responsavel: {{ agenda.funcionario }}</span>
            <br />
        </div>
        <div class="modal-footer">
            <button type="button" class="proxima-etapa" @click="voltar">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </button>

            <button class="confirm">{{ botaoConfirm }}</button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'modalEtapa03',
    props: ["inputsAgendamento", "etapaAtual", "agenda", "botaoConfirm"],
    methods: {
        voltar() {
            this.$emit('voltarEtapa');
        },
    }
}
</script>