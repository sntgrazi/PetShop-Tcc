<template>
  <Navbar v-if="mostrarNavbar" />
  <router-view />
</template>

<script>

import Navbar from './components/Navbar/navbar.vue';
import { useRouter } from 'vue-router';

export default {
  name: "App",
  components: {
    Navbar
  },
  computed: {
    mostrarNavbar() {
      const router = useRouter();
      return router.currentRoute.value.meta.mostrarNavbar !== false;
    },
  },
};
</script>

<style></style>

