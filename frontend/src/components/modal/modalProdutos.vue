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
      <form class="formModal" @submit.prevent="userId == false ? FormCadastro() : FormEdit()"
        enctype="multipart/form-data">
        <div class="form-inputs">
          <div class="container-fluid">
            <div class="col-md-12 col-sm-12">
              <div class="row">
                <div class="col-m-6 col-sm-5">
                  <div class="selectCampo">
                    <label for="tipo">Tipo</label>
                    <select v-model="tipoSelecionado" id="select-tipo" class="selectsForm selecTipo">
                      <option v-for="tipo in tipos" :value="tipo.id" selected>
                        {{ tipo.nome }}
                      </option>

                    </select>
                  </div>

                </div>
                <div class="col-m-6 col-sm-7 " v-show="tipoSelecionado != 2">
                  <BaseInput :modelValue="produtos.nome" @update:modelValue="(newValue) => (produtos.nome = newValue)
                    " :label="'Nome'" :idInput="'inputName'" />
                </div>
                <div class="col-m-6 col-sm-7" v-show="tipoSelecionado == 2">
                  <BaseInput :modelValue="servicos.valor" @update:modelValue="(newValue) => (servicos.valor = newValue)
                    " :label="'Valor (R$)'" />
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="row" v-show="tipoSelecionado != 2">
                  <div class="col-12 col-sm-4 col-md-5">
                    <div class="selectCampo">
                      <label for="tipo">Fornecedor</label>
                      <select v-model="produtos.fornecedor_id" id="select-fornecedor"
                        class="selectsForm selectFornecedor">
                        <option v-for="fornecedor in fornecedores" :value="fornecedor.id">{{ fornecedor.nome_fantasia }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 col-sm-3">
                    <BaseInput :modelValue="produtos.quantidade"
                      @update:modelValue="(newValue) => (produtos.quantidade = newValue)" :label="'Quantidade'"
                      :idInput="'inputCpf'" />
                  </div>
                  <div class="col-6 col-sm-4">
                    <BaseInput :modelValue="produtos.cod_barras"
                      @update:modelValue="(newValue) => (produtos.cod_barras = newValue)" :label="'Cod. Barras'"
                      :idInput="'inputTelefone'" />
                  </div>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-sm-12">
                <div class="row" v-show="tipoSelecionado != 2">
                  <div class="col-6 col-sm-4">
                    <BaseInput :modelValue="produtos.valor_compra"
                      @update:modelValue="(newValue) => (produtos.valor_compra = newValue)"
                      :label="'Valor Compra (R$)'" />
                  </div>
                  <div class="col-6 col-sm-4">
                    <BaseInput :modelValue="produtos.valor_venda"
                      @update:modelValue="(newValue) => (produtos.valor_venda = newValue)" :label="'Valor Venda (R$)'" />
                  </div>
                  <div class="col-12 col-sm-4">
                    <BaseInput :modelValue="produtos.data_validade"
                      @update:modelValue="(newValue) => (produtos.data_validade = newValue)" :label="'Data de Vencimento'"
                      :tipo="'date'" />
                  </div>
                </div>
              </div>
            </div>



            <div class="row">
              <div class="col-sm-12">
                <div class="row" v-show="tipoSelecionado == 2">
                  <div class="col-12 col-sm-12">
                    <BaseInput :modelValue="servicos.nome_servico" @update:modelValue="(newValue) => (servicos.nome_servico = newValue)
                      " :label="'Nome'" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="modal-footer">
          <button class="confirm">
            {{ botaoConfirm }}
          </button>
        </div>

      </form>
    </div>
  </div>
</template>

<script>
import BaseInput from "../BaseInput/BaseInput.vue";
import "select2/dist/css/select2.css";
import "select2";
import $ from "jquery";
import ApiController from "@/ApiController";
import Swal from "sweetalert2";
import loading from "../Outros/loading.vue";

export default {
  name: "modalProdutos",
  props: ["icon", "active", "toggle", "userId"],
  emits: ['atualizarTabela', 'atualizarTabelaP'],
  data() {
    return {
      titulo: this.userId == false ? "Cadastrar Produto/Serviço" : "Produto/Serviço",
      botaoConfirm: this.userId == false ? "Cadastrar" : "Editar",
      loading: true,
      produtos: {},
      servicos: {},
      fornecedores: {},
      tipos: [
        { id: 1, nome: "Produto" },
        { id: 2, nome: "Serviço" },
      ],
      tipoSelecionado: "",
    };
  },
  components: {
    BaseInput,
    loading
  },
  methods: {
    async getAllFornecedores() {
      try {
        this.loading = true
        const fornecedores = await ApiController.getFornecedores();
        this.fornecedores = fornecedores;
        this.loading = false
      } catch (error) {
        console.log("Erro ao listar os fornecedores : ", error);
      }
    },
    async buscar() {
      let abaAtiva = localStorage.getItem('abaAtiva');
      let abaAtivaServicos = localStorage.getItem('abaAtivaServicos');

      if (abaAtiva === 'produtos') {
        this.tipoSelecionado = 1;
        $("#select-tipo").select2();
        $("#select-tipo").val(this.tipoSelecionado).trigger("change");
        try {
          this.loading = true;
          const produto = await ApiController.getProdutoById(this.userId);
          this.produtos = produto;

          $("#select-fornecedor").select2();
          $("#select-fornecedor").val(this.produtos.fornecedor_id).trigger("change");

          this.loading = false;
        } catch (error) {
          console.log(error);
        }
      } else if (abaAtivaServicos === 'servicos') {
        this.tipoSelecionado = 2;
        $("#select-tipo").select2();
        $("#select-tipo").val(this.tipoSelecionado).trigger("change");
        $("#select-tipo").select2();
        try {
          this.loading = true;
          const servicos = await ApiController.getServicosById(this.userId);
          this.servicos = servicos;


          this.loading = false;
        } catch (error) {
          console.log(error);
        }
      }
    },

    async FormCadastro() {

      if (this.tipoSelecionado == 1) {
        const camposValidos = this.validarCamposProduto();

        if (!camposValidos) {
          return;
        }

        try {
          await ApiController.cadastrarProduto(this.produtos);
          Swal.fire("", "Produto cadastrado com sucesso!", "success");
          this.$emit("atualizarTabelaP");
          this.toggle();
          this.produtos = {};
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipoSelecionado == 2) {
        const camposValidos = this.validarCamposServicos();

        if (!camposValidos) {
          return;
        }

        try {
          await ApiController.cadastrarServico(this.servicos);
          Swal.fire("", "Servico cadastrado com sucesso!", "success");
          this.$emit("atualizarTabela");
          this.toggle();
          this.servicos = {};
        } catch (error) {
          console.log(error);
        }
      }
    },
    async FormEdit() {
      if (this.tipoSelecionado == 1) {
        const camposValidos = this.validarCamposProduto();

        if (!camposValidos) {
          return;
        }

        try {
          await ApiController.atualizarProduto(this.userId, this.produtos);
          Swal.fire("", "Produto atualizado com sucesso!", "success");
          this.$emit("atualizarTabelaP");
          this.toggle();
          this.produtos = {};
        } catch (error) {
          console.log(error);
        }
      } else if (this.tipoSelecionado == 2) {

        const camposValidos = this.validarCamposServicos();

        if (!camposValidos) {
          return;
        }

        try {
          await ApiController.atualizarServico(this.userId, this.servicos);
          Swal.fire("", "Serviço atualizado com sucesso!", "success");
          this.$emit("atualizarTabela");
          this.toggle();
          this.servicos = {};
        } catch (error) {
          console.log(error);
        }
      }
    },

    validarCamposProduto() {
      // Verificar se todos os campos obrigatórios estão preenchidos
      if (
        !this.produtos.nome ||
        !this.produtos.quantidade ||
        !this.produtos.cod_barras ||
        !this.produtos.valor_compra ||
        !this.produtos.valor_venda ||
        !this.produtos.data_validade
      ) {
        Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
        return false;
      }

      // Verificar o formato correto do nome
      const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/u;
      if (!regexNome.test(this.produtos.nome)) {
        Swal.fire("Erro", "Digite apenas letras, espaços e acentos no campo Nome.", "error");
        return false;
      }

      const regexNumeros = /^[0-9.,]+$/;
      if (!regexNumeros.test(this.produtos.valor_compra) || !regexNumeros.test(this.produtos.valor_venda) | !regexNumeros.test(this.produtos.quantidade)) {
        Swal.fire("Erro", "Digite apenas números nos campos de Valor Compra e Valor Venda.", "error");
        return false;
      }

      return true;
    },

    validarCamposServicos() {
      // Verificar se todos os campos obrigatórios estão preenchidos
      if (
        !this.servicos.nome_servico ||
        !this.servicos.valor
      ) {
        Swal.fire("Erro", "Preencha todos os campos obrigatórios.", "error");
        return false;
      }

      // Verificar o formato correto do nome
      const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/u;
      if (!regexNome.test(this.servicos.nome_servico)) {
        Swal.fire("Erro", "Digite apenas letras, espaços e acentos no campo Nome.", "error");
        return false;
      }

      // Verificar se o valor do serviço é um número
      const regexNumeros = /^[0-9.,]+$/;
      if (!regexNumeros.test(this.servicos.valor)) {
        Swal.fire("Erro", "Digite apenas números no campo de Valor.", "error");
        return false;
      }

      return true;
    },

  },
  mounted() {

    this.getAllFornecedores();

    if (this.userId == false) {


      this.loading = false
      $("#select-tipo").select2({
        placeholder: "Selecione o tipo",
        width: "100%",
      });


      $("#select-tipo").on("change", (e) => {
        // Obtém a raça selecionada
        this.tipoSelecionado = $("#select-tipo option:selected").val();
      });

      $("#select-fornecedor").select2({
        placeholder: "Selecione o Fornecedor",
        width: "100%",
      });


      $("#select-fornecedor").on("change", (e) => {
        // Obtém a raça selecionada
        this.produtos.fornecedor_id = $("#select-fornecedor option:selected").val();
      });
    } else {
      $("#select-tipo").select2({
        placeholder: "Selecione o tipo",
        width: "100%",
      });
      this.buscar();
    }
  },
};
</script>


<style>
#inputFile {
  color: white;
  border: none;
  padding: 0;
}

#select-fornecedor {
  overflow: hidden;
  text-overflow: ellipsis;
  height: 45px;
  border: 1px solid black;
  border-radius: 7px;
  font-size: 17px;
  outline: none;
  color: #000;
}</style>