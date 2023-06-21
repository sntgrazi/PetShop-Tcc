<template>
  <main class="table">
   
    <section class="table_body">
      <table>
        <thead>
          <tr>
            <th v-for="(topo, index) in topoTabela" :key="index">{{ topo }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(dado, index) in dados" :key="index">

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

            <td @click="abrirInfoFuncionario(dado.id)" class="linhaName" v-if="this.tipo == 'funcionario'">{{ dado.nome }}</td>
            <td v-if="this.tipo == 'funcionario'">{{ dado.cpf }}</td>
            <td v-if="this.tipo == 'funcionario'">{{ dado.telefone }}</td>
            <td v-if="this.tipo == 'funcionario'">{{ dado.nome_cargo }}</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
</template>

<script>
export default {
  name: "tabela",
  props: ["topoTabela", "dados", "tipo"],
  methods: {
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
    }
  },
};
</script>

<style>

.teste{
  width: 280px;
  background-color: #fff;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.inputSearch > input{
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
}</style>