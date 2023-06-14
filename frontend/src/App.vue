<template>
  <Navbar />
  <router-view />
</template>

<script>

import Navbar from './components/Navbar/navbar.vue';

export default {
  name: "App",
  components: {
    Navbar
  }
};
</script>

<style>
</style>

