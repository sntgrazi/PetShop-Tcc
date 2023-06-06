<template>
   <div class="left-content">
      <div v-for="(dado, index) in agendaDados" :key="index">
          <p>{{ dado.nome_cliente }}</p>
          <p>{{ dado.nome_funcionario }}</p>
          <p>{{ dado.nome_servico }}</p>
          <p>{{ dado.nome_animal }}</p>
          <p>{{ dado.status}}</p>
          <p>{{ dado.duracao }}</p>
          <p>{{ dado.hora_inicio}} á {{ dado.hora_termino }}</p>
      </div>
   </div>
</template>

<script>

  export default {
    props: ["agendaDados"]
  }
</script>

<style>
.left-content {
  margin-left: 20px;
  border-radius: 20px;
  width: 30%;
  height: 83vh;
  background-color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-evenly;
  gap: 30px;
}
.left-content .gif {
  width: 50%;
}
.left-content h2 {
  color: #1E90FF;
}
.left-content h3 {
  color: #868585;
  text-align: center;
  font-size: 18px
}
@media screen and (max-width: 1010px) {
.left-content {
    margin-top: 20px;
    width: 100%;
    margin-left: 0px;
  }
  .left-content h1 {
    color: #5177e0;
    margin-top: 20px;
    margin-bottom: 100px;
  }
  .left-content h3 {
    color: #868585;
    margin-left: 10px;
  }
}
</style>