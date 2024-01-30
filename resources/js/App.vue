<script setup>
import Menu from './component/menu.vue';
import Footer from'./component/footer.vue';
</script>

<template>
    <div>
      <Menu />
      <router-view></router-view>
      <Footer />
    </div>
  </template>
<style scoped>
.sticky-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #f1f1f1;
  padding: 10px;
  z-index: 1000;
}
</style>