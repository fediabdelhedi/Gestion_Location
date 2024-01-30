<template>
  <div id="app">
    <!-- Votre contenu ici -->
    <div class="content">
      <!-- Contenu de la page -->
    </div>

    <!-- Footer -->
    <footer style="background-color: #ada7a773">
      <!-- Copyright -->
      <div class="text-center p-4" style="background-color: #ada7a773">
        © 2024 Copyright: Fedi Abdelhedi
         
      </div>
      <!-- Copyright -->
    </footer>
  </div>
</template>

<script>
export default {
  // Options du composant
};
</script>

<style scoped>
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Garantit que le contenu s'étend sur au moins la hauteur de la vue */
}

.content {
  flex: 1; /* Permet au contenu de prendre autant d'espace que possible */
}
</style>
