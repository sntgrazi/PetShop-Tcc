<template>
  <loading v-show="this.tipo == 'estoque'" :loading="loading" />
  <main class="table">
    <section class="table_body">
      <div class="abas" v-if="this.tipo == 'estoque'">
        <button @click="selecionarAba('produtos')" :class="{ 'active': abaAtiva === 'produtos' }">Produtos</button>
        <button @click="selecionarAba('servicos')" :class="{ 'active': abaAtiva === 'servicos' }">Servicos</button>
      </div>
      <table>
        <thead>
          <tr>
            <th v-show="this.tipo != 'estoque'" v-for="(topo, index) in topoTabela" :key="index">{{ topo }}</th>
            <th v-show="this.tipo == 'estoque'" v-for="(topo, index) in  topoTabelaProduto" :key="index">{{ topo }}</th>
          </tr>
        </thead>

        <tbody>
          <tr v-show="this.tipo != 'estoque'" v-for="(dado, index) in dados" :key="index">

            <td v-if="topoTabela.includes('ID')">{{ dado.id }}</td>
            <!-- Dados da tabela Cliente -->

            <td @click="abrirInfoCliente(dado.id)" class="linhaName" v-if="this.tipo == 'cliente'">
              {{ dado.nome }}</td>
            <td v-if="this.tipo == 'cliente'">{{ dado.cpf }}</td>
            <td v-if="this.tipo == 'cliente'">{{ dado.telefone }}</td>
            <td v-if="this.tipo == 'cliente'">{{ dado.email }}</td>

            <!-- Dados da tabela Animal -->
            <td @click="abrirInfoAnimal(dado.id)" class="linhaName" v-if="this.tipo == 'pet'">{{ dado.nome_pet }}</td>
            <td v-if="this.tipo == 'pet'">{{ dado.sexo }}</td>
            <td v-if="this.tipo == 'pet'">{{ dado.raca }}</td>
            <td v-if="this.tipo == 'pet'">{{ dado.porte }}</td>

            <td @click="abrirInfoFuncionario(dado.id)" class="linhaName" v-if="this.tipo == 'funcionario'">{{ dado.nome }}
            </td>
            <td v-if="this.tipo == 'funcionario'">{{ dado.cpf }}</td>
            <td v-if="this.tipo == 'funcionario'">{{ dado.telefone }}</td>
            <td v-if="this.tipo == 'funcionario'">{{ dado.nome_cargo }}</td>

            <td v-if="this.tipo == 'fornecedor'">{{
              dado.nome_fantasia }}
            </td>
            <td v-if="this.tipo == 'fornecedor'">{{ dado.cnpj }}</td>
            <td v-if="this.tipo == 'fornecedor'">{{ dado.telefone }}</td>
            <td v-if="this.tipo == 'fornecedor'">{{ dado.email }}</td>
            <td v-if="this.tipo == 'fornecedor'">
              <button class="btnEditarOffCanvas" id="btn-editar"
                @click="abriModalEdit(dado.id)">
                <i style="color: rgb(8, 83, 153);" class="fa-solid fa-pen"></i>
              </button>
              <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(dado.id)">
                <i style="color: red;" class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>

          <tr v-if="abaAtiva === 'produtos' && this.tipo == 'estoque'" v-for="(dado, index) in dados" :key="index">
            <td>{{ dado.cod_barras }}</td>
            <td @click="abrirInfoProduto(dado.id)" class="linhaName"> {{ dado.nome }}</td>
            <td>{{ dado.quantidade }}</td>
            <td>R$ {{ dado.valor_venda }}</td>
            <td>{{ dado.data_validade }}</td>

          </tr>

          <tr v-if="abaAtiva === 'servicos' && this.tipo == 'estoque'" v-for="(dado, index) in dadosServicos"
            :key="index">
            <td>{{ dado.id }}</td>
            <td>{{ dado.nome_servico }}</td>
            <td>R$ {{ dado.valor }}</td>
            <td><button class="btnEditarOffCanvas" id="btn-editar" @click="abriModalEdit(dado.id)">
                <i style="color: rgb(8, 83, 153);" class="fa-solid fa-pen"></i>
              </button>
              <button class="btnEditarOffCanvas" id="btn-deletar" @click="excluir(dado.id)">
                <i style="color: red;" class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>

        </tbody>
      </table>
    </section>
  </main>
</template>

<script>

import loading from './loading.vue';

export default {
  name: "tabela",
  props: ["topoTabela", "dados", "tipo", "dadosServicos", "toggle"],
  emits: ['dadosServicos', 'dadosProdutos', 'infoAnimal', 'infoCliente', 'infoFuncionario', 'info', 'deletar', 'abrirModalEdit', 'infoProduto', 'infoFornecedor'],
  components: {
    loading
  },
  data() {
    return {
      abaAtiva: '',
      topoTabelaProduto: [],
      loading: false,
    }
  },
  watch: {
    abaAtiva(novaAba) {
      if (novaAba === 'produtos') {
        this.topoTabelaProduto = ['COD. BARRAS', 'PRODUTO', 'QUANTIDADE', 'VALOR', 'VALIDADE'];
        localStorage.setItem('abaAtiva', novaAba);
        localStorage.removeItem('abaAtivaServicos');
      } else if (novaAba === 'servicos') {
        this.topoTabelaProduto = ['ID', 'NOME', 'VALOR', 'AÇÕES'];
        localStorage.setItem('abaAtivaServicos', novaAba);
        localStorage.removeItem('abaAtiva');
      }
    },

  },
  mounted() {
    this.abaAtiva = 'produtos';
  },
  methods: {
    excluir(id) {
      this.$emit("deletar", id)
    },
    abriModalEdit(id) {
      this.toggle('info', id)
    },
    modalTutores(id) {
      this.$emit('tutor', id)
    },
    abrirInfoCliente(id) {
      this.$emit('infoCliente', id)
    },
    abrirInfoAnimal(id) {
      this.$emit('infoAnimal', id)
    },
    abrirInfoFuncionario(id) {
      this.$emit('infoFuncionario', id)
    },
    abrirInfoProduto(id) {
      this.$emit('infoProduto', id)
    },
    selecionarAba(aba) {
      this.abaAtiva = aba

      if (this.abaAtiva == 'produtos') {
        this.$emit('dadosProdutos')
      } else if (this.abaAtiva == 'servicos') {
        this.$emit('dadosServicos')
      }
    },
  },
};
</script>

<style>
.abas {
  text-align: center;
  width: 100%;
  display: flex;
  flex-direction: row;
}

.abas>button {
  width: 100%;
  background-color: transparent;
  border: none;
  border-bottom: 2px solid transparent;
  border-radius: 0;
  padding: 0.5rem;
  cursor: pointer;
}

.abas>button.active {
  border-bottom: 2px solid #007bff;
}


.teste {
  width: 280px;
  background-color: #fff;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.inputSearch>input {
  outline: none;
  width: 250px;
  height: 40px;
  padding: 10px;
  border-radius: 15px;
  color: black;
}

main.table {
  width: 100%;
  height: 100vh;

  margin-bottom: 20px;

  border-radius: 0.8rem;

  overflow: hidden;
}

.table_body {
  width: 95%;
  height: 75vh;

  margin: 0.8rem auto;
  border-radius: 0.8rem;

  overflow: auto;
  overflow: overlay;
}

.table_header {
  width: 100%;
  height: 10%;
  background-color: #fff4;
  padding: 0.8rem 1rem;

  display: flex;
  justify-content: space-between;
  align-items: center;
}

.table_header .input-group {
  width: 35%;
  height: 100%;
  background-color: #fff5;
  padding: 15px;
  border-radius: 2rem;

  display: flex;
  justify-content: center;
  align-items: center;

  transition: 0.2s;
}

.table_header .input-group:hover {
  width: 45%;
  background-color: #fff8;
  box-shadow: 0 0.1rem 0.4rem #0002;
}

.table_header .input-group img {
  width: 1.2rem;
  height: 1.2rem;
}

.table_header .input-group input {
  width: 100%;
  padding: 0 0.5rem 0 0.3rem;
  background-color: transparent;
  border: none;
  outline: none;
}

.table_body::-webkit-scrollbar {
  width: 0.5rem;
  height: 0.5rem;
}

.table_body::-webkit-scrollbar-thumb {
  border-radius: 0.5rem;
  background-color: #0004;
  visibility: hidden;
}

.table_body:hover::-webkit-scrollbar-thumb {
  visibility: visible;
}

table {
  width: 100%;

}

table,
th,
td {
  border-collapse: collapse;
  padding: 1em;
  text-align: center;

}

.linhaName {
  text-decoration: underline;
  cursor: pointer;
}

.linhaName:hover {
  color: blue;
}


thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #1E90FF;
  cursor: pointer;
  text-align: center;
  text-transform: capitalize;
  color: white;

}

thead th:first-child {
  border-top-left-radius: 10px;
}

thead th:last-child {
  border-top-right-radius: 10px;
}

tbody tr:nth-child(even) {
  background-color: #ffffff0b;
}

tbody tr {
  --delay: 0.1s;
  transition: 0.5s ease-in-out var(--delay), background-color 0s;

}

tbody tr.hide {
  opacity: 0;
  transform: translateX(100%);
}

tbody tr:hover {
  background-color: #fff6 !important;
}

tbody tr td,
tbody tr td p,
tbody tr td img {
  transition: 0.2s ease-in-out;
}

tbody tr.hide td,
tbody tr.hide td p {
  padding: 0;
  font: 0 / 0 sans-serif;
  transition: 0.2s ease-in-out 0.5s;
}

tbody tr.hide td img {
  width: 0;
  height: 0;
  transition: 0.2s ease-in-out 0.5s;
}

thead th:hover {
  color: #02396f;
  transition: 1s;
}


thead th.active,
tbody td.active {
  color: #02396f;
}

tbody,
td,
tfoot,
th,
thead,
tr {
  border-style: none;
}

.btn-pet {
  background-color: #1E90FF;
  border: none;
  color: white;
  font-size: 18px;
  border-radius: 10px;
  padding: 8px;
  cursor: pointer;
  box-shadow: 0 1px 1px 0 #000000;
  transition: 0.1s all;
}

.btn-pet:active {
  transform: scale(0.9);
  box-shadow: 2px 2px var(--black);
}
</style>