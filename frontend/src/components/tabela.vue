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
            <td>{{ dado.id }}</td>
            <td>{{ dado.nome }}</td>
            <td>{{ dado.cpf }}</td>
            <td>{{ dado.telefone }}</td>
            <td>
              <button class="btn-acoes" id="btn-editar" @click="() => toggle(dado.id)">
                <i class="fa-solid fa-pencil"></i>
              </button>
              <button class="btn-acoes" id="btn-deletar" @click="excluirCliente(dado.id)">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>
</template>

<script>
export default {
  name: "tabela",
  props: ["topoTabela", "dados", "toggle"],
  methods: {
    excluirCliente(id){
      this.$emit("deletarCliente", id)
    }
  }
  
};
</script>

<style>
main.table {
  width: 100%;
  height: 100vh;

  margin-bottom: 20px;

  border-radius: 0.8rem;

  overflow: hidden;
}

.table_body {
  width: 95%;
  height: 65vh;

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

td img {
  width: 36px;
  height: 36px;
  margin-right: 0.5rem;
  border-radius: 50%;

  vertical-align: middle;
}

table,
th,
td {
  border-collapse: collapse;
  padding: 1rem;
  text-align: center;
}

thead th {
  position: sticky;
  top: 0;
  left: 0;
  background-color: #d5d1defe;
  cursor: pointer;
  text-align: center;
  text-transform: capitalize;
}

tbody tr:nth-child(even) {
  background-color: #0000000b;
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

.status {
  padding: 5px;
  border-radius: 10px;
  text-align: center;
}

.status.aguardando {
  background-color: #c261ff;
  color: #8800dc;
}

.status.atendendo {
  background-color: rgb(96, 170, 255);
  color: rgb(0, 38, 255);
}

.status.concluido {
  background-color: rgb(144, 255, 144);
  color: green;
}

.status.cancelado {
  background-color: rgb(255, 169, 169);
  color: red;
}

thead th:hover span.icon-arrow {
  border: 1.4px solid #6c00bd;
}

thead th:hover {
  color: #6c00bd;
}

thead th.active span.icon-arrow {
  background-color: #6c00bd;
  color: #fff;
}

thead th.asc span.icon-arrow {
  transform: rotate(180deg);
}

thead th.active,
tbody td.active {
  color: #6c00bd;
}

.btn-acoes {
  border: none;
  font-size: 20px;
  margin: 0 5px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  color: #fff;
  box-shadow: 0 1px 1px 0 #000000;
  transition: 0.1s all;
}

.btn-acoes:active {
  transform: scale(0.9);
  box-shadow: 2px 2px var(--black);
}

#btn-editar {
  background-color: rgb(83, 93, 228);
}

#btn-deletar {
  background-color: red;
}

.btn-pet {
  background-color: rgb(83, 93, 228);
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