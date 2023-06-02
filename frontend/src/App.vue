<template>
  <Navbar />
  <router-view />
</template>

<script>

import Navbar from './components/navbar.vue';

export default {
  name: "App",
  components: {
    Navbar
  }
};
</script>

<style>

.row {
  display: flex;
  justify-content: space-between;
}

.container {
  margin-top: 80px;
}

.content {
  display: flex;
  flex-direction: row;
  height: 78vh;
}

.main-content {
  border-radius: 20px;
  width: 100%;
  background-color: white;
  display: flex;
  flex-direction: column;
  height: 100%;
}

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

