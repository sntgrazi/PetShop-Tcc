<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Agendamento</h5>

      <div class="btnAcaoOff">
        <button class="btnEditarOffCanvas" type="button"><i class="fa-solid fa-pen"></i></button>
        <button class="btnEditarOffCanvas" type="button"><i class="fa-solid fa-trash"></i></button>
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
          <p> {{ agendaDados.data_inicio }} - {{ agendaDados.hora_inicio }} ás {{ agendaDados.hora_termino }}</p>
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
            <h4> Status </h4>
          </div>
          <hr>
          <div class="detalhesInfoStatus">
            <span> <i class="fa-sharp fa-regular fa-circle-dot"></i> </span>
            <span>{{ agendaDados.status }}</span>
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
          <button class="btnIniciar" type="button" v-if="this.agendaDados.status !== 'Concluído'"
            @click="atualizarStatus(this.agendaDados)"> {{
              getButtonText(this.agendaDados.status) }}</button>
          <button class="btnCancelar" type="button" v-if="this.agendaDados.status !== 'Concluído'"> Cancelar
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
  props: ["agendaDados"],
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
          mensagemAlerta = 'Atendimeno Concluído';
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
  }

}
</script>

