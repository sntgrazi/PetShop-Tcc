<template>
  <Navbar />
  <router-view />
</template>

<script>
import "@/assets/css/style.css";  
import Navbar from './components/navbar.vue';

export default {
  name: "App",
  components: {
    Navbar
  }
};
</script>

<style>

@media screen and (min-width: 768px) {
  /*Show navbar desktop*/
  .show {
    width: calc(var(--nav-width) + 156px);
  }
  /*Add padding body desktop*/
  .body-pd {
    padding-left: calc(var(--nav-width) + 160px);
  }
}
@media screen and (max-width: 901px) {
  .content {
    flex-direction: column;
  }
  main.table {
    width: 85vw;
  }
}
</style>

