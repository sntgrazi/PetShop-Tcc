<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Cliente</h5>
      <div class="btnAcaoOff">
        <button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(cliente.id)">
          <i style="color: rgb(8, 83, 153);" class="fa-solid fa-pen"></i>
        </button>
        <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(cliente.id)">
          <i style="color: red;" class="fa-solid fa-trash"></i>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
    </div>
    <div class="offcanvas-body">
      <div class="informacoes">
        <h4 style="color: #1e90ff;" class="mb-4">Dados Pessoais</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="mb-3">
              <h6>Nome</h6>
              <p>{{ cliente.nome }}</p>
            </div>
            <div class="mb-3">
              <h6>Cpf</h6>
              <p>{{ cliente.cpf }}</p>
            </div>
          </div>
          <div class="col-md-12">
            <div class="mb-3">
              <h6>Telefone</h6>
              <p>{{ cliente.telefone }}</p>
            </div>
            <div class="mb-3">
              <h6>Email</h6>
              <p>{{ cliente.email }}</p>
            </div>
          </div>
        </div>
        <hr class="mb-4">

        <h4 style="color: #1e90ff;" class="mt-4 mb-4">Endereço</h4>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <h6>Cep</h6>
              <p>{{ cliente.cep }}</p>
            </div>
            <div class="mb-3">
              <h6>Bairro</h6>
              <p>{{ cliente.bairro }}</p>
            </div>
            <div class="mb-duo">
             <div class="linhaEnd">
              <h6>Nº</h6>
              <p>{{ cliente.n_casa }}</p>
             </div>
             <div class="linhaen">
              <h6>Uf</h6>
              <p>{{ cliente.uf }}</p>
             </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <h6>Cidade</h6>
              <p>{{ cliente.cidade }}</p>
            </div>
            <div class="mb-3">
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
  props: ["cliente", "toggle"],
  data() {
    return {
      endereco: []
    }
  },
  methods: {
    excluir(id) {
      this.$emit("deletar", id)
    },
    abriModalEdit(id) {
      $('#offcanvasRight').offcanvas('hide');
      this.toggle('info', id)
    },
  }
}
</script>

<style>
.offcanvas-title {
  color: #333;
}

.btnAcaoOff {
  display: flex;
  gap: 5px;
}

.btnEditarOffCanvas {
  background-color: transparent;
  border: none;
  color: #333;
  cursor: pointer;
  font-size: 18px;
  transition: color 0.3s;
}

.btnEditarOffCanvas:hover {
  color: #007bff;
}


h4 {
  font-size: 22px;
  font-weight: bold;
}

h6 {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 5px;
}

p {
  margin: 0;
}

.mb-duo{
  display: flex;
  gap: 40px;
  margin-bottom: 15px;
}

.mb-3 {
  margin-bottom: 15px;
}

.mt-4 {
  margin-top: 20px;
}

</style>
