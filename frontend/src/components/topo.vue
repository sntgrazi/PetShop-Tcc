<template>
  <div class="row">
    <div class="titulo">
      <h1>{{ type }}</h1>
    </div>
    <button v-on:click="toggle" id="open-modal">
      <i :class="['fa regular', icon]"></i>
      {{ botaoAdd }}
    </button>
  </div>
</template>

<script>


export default {
  name: "topo",
  props: {
    type: String,
    icon: String,
    toggle: Function
  },
  data() {
    return {
      botaoAdd: this.type === "Clientes" ? "Novo Cliente" : "Novo Agendamento",
    };
  },
};
</script>

<style>
.titulo {
  color: #4d72d6;
  font-size: 1.2em;
  margin-left: 10px;
}

#open-modal {
  padding: 0.6rem 1.2rem;
  background-color: #4d72d6;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1.1rem;
  margin-bottom: 15px;
  margin-right: 5px;
  transition: 0.2s all;
}

#open-modal i {
  font-size: 20px;
  margin-right: 10px;
}

#open-modal:active {
  transform: scale(0.95);
  box-shadow: 2px 2px var(--black);
}

@media screen and (max-width: 370px) {
  #open-modal {
    padding: 5px;
    width: 10em;
  }
}

@media screen and (max-width: 370px) {
  #open-modal {
    padding: 5px;
    width: 150px;
  }
}
</style>