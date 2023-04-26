<template>
  <Navbar />
  <router-view />
</template>

<script>

import Navbar from "./components/navbar.vue";

export default {
  name: "App",
  components: {
    Navbar,
  },
};
</script>

<style>
  section {
  margin: auto;
}

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
  height: 78vh;
}
</style>

