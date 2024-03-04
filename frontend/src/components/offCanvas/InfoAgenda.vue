<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Agendamento</h5>

      <div class="btnAcaoOff">
        <button @click="abriModalEdit(agendaDados.id)" class="btnEditarOffCanvas" type="button"><i
          style="color: rgb(8, 83, 153);" class="fa-solid fa-pen"></i></button>
        <button @click="deletar(agendaDados.id)" class="btnEditarOffCanvas" type="button"><i
          style="color: red;" class="fa-solid fa-trash"></i></button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
    <div class="offcanvas-body">
      <div>
        <div class="servicoDetalhes">
          <div class="detalhesTitulo">
            <h4>{{ agendaDados.nome_servico }}</h4>
          </div>
          <hr>
          <h6>Data e Hora</h6>
          <p> {{ agendaDados.data_inicio }} - {{ agendaDados.hora_inicio }} às {{ agendaDados.hora_termino }}</p>
          <div class="servicoDetalhescolumn">
            <div class="colunaDetalhes">
              <h6>Duração Aprox.</h6>
              <p>{{ agendaDados.duracao }}</p>
            </div>
            <div class="colunaDetalhes">
              <h6>Profissional</h6>
              <p>{{ agendaDados.nome_funcionario }}</p>
            </div>
          </div>
        </div>
        <div class="servicoDetalhes">
          <div class="detalhesTitulo">
            <h4>Status</h4>
          </div>
          <hr>
          <div class="detalhesInfoStatus">
            <span :class="getStatusClass(agendaDados.status)">
              <i :class="getStatusIcon(agendaDados.status)"></i>
            </span>
            <span :class="getStatusClass(agendaDados.status)" >{{ agendaDados.status }}</span>
          </div>
        </div>


        <div class="servicoDetalhes">
          <div class="detalhesTitulo">
            <h4>Cliente</h4>
          </div>
          <hr>
          <div class="detalhesCliente">
            <span><i class="fa-solid fa-user"></i></span>
            <span>{{ agendaDados.nome_cliente }}</span>
          </div>
          <div class="detalhesAnimal">
            <span><i class="fa-solid fa-paw"></i></span>
            <span>{{ agendaDados.nome_animal }}</span>
          </div>
        </div>


        <div class="btnAcoesAgendamento">
          <button class="btnIniciar" type="button"
            v-if="this.agendaDados.status !== 'Concluído' && this.agendaDados.status !== 'Cancelado'"
            @click="atualizarStatus(this.agendaDados)"> {{
              getButtonText(this.agendaDados.status) }}</button>
          <button @click="cancelarAgendamento(this.agendaDados)" class="btnCancelar" type="button"
            v-if="this.agendaDados.status !== 'Concluído' && this.agendaDados.status !== 'Cancelado'"> Cancelar
            Agendamento</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import ApiController from "@/ApiController";
import Swal from "sweetalert2";

export default {
  props: ["agendaDados", "toggle"],
  methods: {
    getButtonText(status) {
      if (status === 'Aguardando atendimento') {
        return 'Iniciar Atendimento';
      } else if (status === 'Em atendimento') {
        return 'Concluir Atendimento';
      } else {
        return '';
      }
    },
    async atualizarStatus(agenda) {
      try {
        let mensagemAlerta = ''
        let status = ''

        if (agenda.status === 'Aguardando atendimento') {
          status = 'Em atendimento';
          mensagemAlerta = 'Atendimento Iniciado';
        } else if (agenda.status == 'Em atendimento') {
          status = 'Concluído';
          mensagemAlerta = 'Atendimento Concluído';
        } else if (agenda.status == 'Cancelado') {
          status = 'Concluído';
          mensagemAlerta = 'Atendimento Concluído';
        }

        await ApiController.updateStatus(agenda.id, status);
        $('#offcanvasRight').offcanvas('hide');
        Swal.fire('', mensagemAlerta, "success").then(() => {
          window.location.reload();
        });

      } catch (error) {
        console.log('Erro ao tentar atualizar o status do agendamento: ', error)
      }
    },
    async cancelarAgendamento(agenda) {
      try {
        let status = 'Cancelado'

        await ApiController.updateStatus(agenda.id, status);
        $('#offcanvasRight').offcanvas('hide');
        Swal.fire('', "Agendamento Cancelado", "success").then(() => {
          window.location.reload();
        });

      } catch (error) {
        console.log('Erro ao tentar atualizar o status do agendamento: ', error)
      }
    },
    abriModalEdit(id) {
      $('#offcanvasRight').offcanvas('hide');
      this.toggle('info', id)
    },
    deletar(id) {
      this.$emit('deletarAgendamento', id)
    },
    getStatusClass(status) {
      if (status === 'Aguardando atendimento') {
        return 'statusAguardando';
      } else if (status === 'Em atendimento') {
        return 'statusEmAtendimento';
      } else if (status === 'Concluído') {
        return 'statusConcluido';
      } else if (status === 'Cancelado') {
        return 'statusCancelado';
      } else {
        return '';
      }
    },
    getStatusIcon(status) {
      if (status === 'Aguardando atendimento') {
        return 'fa-sharp fa-regular fa-circle-dot';
      } else if (status === 'Em atendimento') {
        return 'fa-sharp fa-regular fa-circle';
      } else if (status === 'Concluído') {
        return 'fa-sharp fa-regular fa-check-circle';
      } else if (status === 'Cancelado') {
        return 'fa-sharp fa-regular fa-times-circle';
      } else {
        return '';
      }
    }
  }

}
</script>

<style>
.statusAguardando {
  color: orange;
}

.statusEmAtendimento {
  color: blue;
}

.statusConcluido {
  color: green;
}

.statusCancelado {
  color: red;
}
</style>
