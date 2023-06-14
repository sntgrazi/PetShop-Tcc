<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Cliente</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="informacoes">
        <h4>Dados Pessoais</h4>
        <hr>
        <div class="dadosPessoais">
          <div class="colunaDados">
            <div class="dadosDetalhes">
              <h6>Nome</h6>
              <p>{{ cliente.nome }}</p>
            </div>

            <div class="dadosDetalhes">
              <h6>Cpf</h6>
              <p>{{ cliente.cpf }}</p>
            </div>
          </div>
          <div class="colunaDados">
            <div class="dadosDetalhes">
              <h6>Telefone</h6>
              <p>{{ cliente.telefone }}</p>
            </div>
            <div class="dadosDetalhes">
              <h6>Email</h6>
              <p>{{ cliente.email }}</p>
            </div>
          </div>
        </div>

        <h4> Endereço </h4>
        <hr>
        <div class="dadosPessoais">
          <div class="colunaDados">
            <div class="dadosDetalhes">
              <h6>Cep</h6>
              <p>{{ cliente.cep }}</p>
            </div>
            <div class="dadosDetalhes">
              <h6>Bairro</h6>
              <p>{{ cliente.bairro }}</p>
            </div>
            <div class="dadosDetalhes">
              <h6>Nº</h6>
              <p>{{ cliente.n_casa }}</p>
            </div>
            <div class="dadosDetalhes">
              <h6>Uf</h6>
              <p>{{ cliente.uf }}</p>
            </div>
          </div>
          <div class="colunaDados">
            <div class="dadosDetalhes">
              <h6>Cidade</h6>
              <p>{{ cliente.cidade }}</p>
            </div>
            <div class="dadosDetalhes">
              <h6>Rua</h6>
              <p>{{ cliente.rua }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'infoCliente',
  props: ['cliente'],
  data() {
    return {
      endereco: []

    }
  },


}

</script>

<style>
.dadosPessoais {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-bottom: 15px;
  width: 100%;
}

.colunaDados {
  width: 100%;
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 50px;
}

.dadosDetalhes{
  width: 100%;
}
</style>