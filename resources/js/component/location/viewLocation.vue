<template>
    <nav class="navbar navbar-expand-lg navbar-dark darg">
    <div class="container-fluid">
      <h3>Liste des Locations</h3>
    </div>
  </nav>
  <div>
    <div class="card">
      <DataTable
        :value="Locations"
        :paginator="true"
        :rows="10"
        :rowsPerPageOptions="[5, 10, 20]"
      >
        <Column field="date_debut" header="Date debut" sortable></Column>
        <Column field="date_fin" header="Date fin" sortable></Column>
        <Column field="prix_total" header="Prix total" sortable></Column>
        <Column field="etat" header="Etat" sortable></Column>
        <Column field="voitures.matricule" header="Voiture" sortable></Column>
        <Column field="userID" header="Client" sortable></Column>
      </DataTable>
    </div>
  </div>
</template>
  
  <script setup>
import axios from "axios";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import { ref, onMounted, watch } from "vue";


const Locations = ref([]);
const isLoading = ref(true);

const fetchLocations = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/locations");
    Locations.value = response.data;
    updateLocationStates();
    isLoading.value = false;
  } catch (error) {
    console.error("Error fetching Locations:", error);
  }
};

const updateLocationStates = () => {
  const currentDate = new Date();

  Locations.value.forEach((location) => {
    const endDate = new Date(location.date_fin);

    // Vérifier si la date actuelle est supérieure à la date de fin
    if (currentDate > endDate) {
      // Mettre à jour l'état de la location à "termine"
      location.etat = "terminé";
    }
  });
};
onMounted(() => {
  fetchLocations();
});

// Use a watcher to handle changes to the Locations data
watch(
  () => Locations.value,
  () => {
    // You can add any additional logic here if needed
  }
);
</script>
  
  <style lang="scss" scoped>
.darg{
  margin-top: 60px;
}
</style>