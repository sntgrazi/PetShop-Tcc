<template>
  <Navbar v-if="mostrarNavbar" />
  <router-view />
</template>

<script>

import Navbar from './components/Navbar/navbar.vue';

export default {
  name: "App",
  components: {
    Navbar
  },
  computed: {
    mostrarNavbar() {
      const token = localStorage.getItem('token');
      const rotaAtual = this.$route;

      // Verifica se há um token e se a rota atual permite mostrar a navbar
      return token && (rotaAtual.meta.mostrarNavbar !== false);
    }
  },
};
</script>

<style></style>

