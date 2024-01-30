<template>
    <div>
        <Addvoiture :fetchCars="fetchCars" />
      <div class="card">
        <DataTable
          :value="voitures"
          :paginator="true"
          :rows="10"
          :rowsPerPageOptions="[5, 10, 20]"
        >
          <Column field="matricule" header="Matricule" sortable></Column>
          <Column field="marque" header="Marque" sortable></Column>
          <Column field="model" header="Modèle" sortable></Column>
          <Column field="couleur" header="Couleur" sortable></Column>
          <Column field="date_fabrication" header="Date de Fabrication" sortable></Column>
          <Column field="prix" header="Prix" sortable></Column>
          <Column style="min-width: 12rem" header="Actions">
            <template #body="val">
              <div class="d-flex">
                <Editvoiture :car="val.data" :fetchCars="fetchCars" />
                <button class="btn btn-danger" @click="deleteCar(val.data.id)">

                    <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-trash"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"
                  />
                  <path
                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"
                  />
                </svg>
                </button>
              </div>
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </template>
  
  <script setup>
  import axios from "axios";
  import DataTable from "primevue/datatable";
  import Column from "primevue/column";
  import { ref, onMounted, watch } from "vue";
  import Addvoiture from "./Addvoiture.vue";
  import Editvoiture from "./Editvoiture.vue";
  
  const voitures = ref([]);
  const isLoading = ref(true);
  
  const fetchCars = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/voitures");
      voitures.value = response.data;
      isLoading.value = false;
    } catch (error) {
      console.error("Error fetching cars:", error);
    }
  };
  
  const deleteCar = async (carId) => {
    if (window.confirm("Are you sure you want to delete this car?")) {
      try {
        // Implement logic for deleting a car
        await axios.delete(`http://localhost:8000/api/voitures/${carId}`);
        fetchCars();
      } catch (error) {
        console.error("Error deleting car:", error);
      }
    }
  };
  
  onMounted(() => {
    fetchCars();
  });
  
  // Use a watcher to handle changes to the cars data
  watch(
    () => voitures.value,
    () => {
      // You can add any additional logic here if needed
    }
  );
  </script>
  
  <style lang="scss" scoped>
  /* Add styles if necessary */
  </style>