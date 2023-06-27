<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
          <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasRightLabel">Produto</h5>
              <div class="btnAcaoOff">
                  <button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(produto.id)">
                      <i style="color: rgb(52, 136, 149);" class="fa-solid fa-pen"></i>
                  </button>
                  <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(produto.id)">
                      <i style="color: red;" class="fa-solid fa-trash"></i>
                  </button>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
          </div>
          <div class="offcanvas-body">
              <div class="informacoes">
          <h4 style="color: #1e90ff;" class="mb-4">Dados do Produto</h4>
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <h6>Nome do Produto</h6>
                <p>{{ produto.nome }}</p>
              </div>
              <div class="mb-3">
                <h6>Quantidade</h6>
                <p>{{produto.quantidade}}</p>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-3">
                <h6>Data de Vencimento</h6>
                <p>{{produto.data_validade}}</p>
              </div>
              <div class="mb-3">
                <h6>Cod.Barras</h6>
                <p>{{produto.cod_barras}}</p>
              </div>
            </div>
          </div>
          <hr class="mb-4">
          <h4 style="color: #1e90ff;" class="mt-4 mb-4">Fornecedor</h4>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <h6>Fornecedor</h6>
                <p>{{produto.fornecedor_nome}}</p>
              </div>
              <div class="mb-3">
                <h6>Valor da Compra</h6>
                <p>{{produto.valor_compra}}</p>
              </div>
              <div class="mb-3">
                <h6>Valor para Venda</h6>
                <p>{{produto.valor_venda}}</p>
              </div>
  
            </div>
          </div>
          </div>
          </div>
      </div>
  
  </template>
  
  <script>
  export default{
      name: 'InfoProduto',
      props: ['produto', 'toggle'],
      methods: {
          abriModalEdit(id) {
              $('#offcanvasRight').offcanvas('hide');
              this.toggle('info', id)
          },
          excluir(id) {
              console.log(id)
              this.$emit("deletar", id)
          },
      }
  }
  </script>