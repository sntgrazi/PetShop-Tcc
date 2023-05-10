<template>
   <div class="left-content">
    <h2>Agendamento</h2>
    <h3>Nenhum agendamento selecionado</h3>
    <img class="gif" src="@/assets/img/blue.gif" alt="searchGif" />
    <h3>Selecione um agendamento para visualizar os detalhes</h3>
   </div>
</template>



<style>
.left-content {
  margin-left: 20px;
  border-radius: 20px;
  width: 28%;
  height: 78vh;
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
@media screen and (max-width: 901px) {
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