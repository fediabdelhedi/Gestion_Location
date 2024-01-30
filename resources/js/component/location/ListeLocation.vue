<template>
    <AddLocation fetchLocations:fetchLocations/>
    <div>
      <div class="card">
        <DataTable
          :value="filteredLocations"
          :paginator="true"
          :rows="10"
          :rowsPerPageOptions="[5, 10, 20]"
        >
          <Column field="date_debut" header="Date debut" sortable></Column>
          <Column field="date_fin" header="Date fin" sortable></Column>
          <Column field="prix_total" header="Prix total" sortable></Column>
          <Column field="etat" header="Etat" sortable></Column>
          <Column field="voitures.matricule" header="Voiture" sortable></Column>
          <Column style="min-width: 12rem" header="Actions">
            <template #body="val">
                <button class="btn btn-danger" @click="deleteLoc(val.data.id)">

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
  import AddLocation from "./AddLocation.vue";
  
  const Locations = ref([]);
  const isLoading = ref(true);
  const isLoggedIn = ref(false);
  const userid = ref(null);
  const filteredLocations = ref([]);
  
  const fetchLocations = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/locations");
      Locations.value = response.data;
      updateLocationStates();
      isLoading.value = false;
      filterLocations();
    } catch (error) {
      console.error("Error fetching Locations:", error);
    }
  };
  
  const updateLocationStates = () => {
    const currentDate = new Date();
  
    Locations.value.forEach((location) => {
      const endDate = new Date(location.date_fin);
  
      if (currentDate > endDate) {
        location.etat = "terminé";
      }
    });
  };
  
  const fetchUserInfo = async () => {
    try {
      const token = localStorage.getItem("token");
      if (token) {
        const response = await axios.get("http://localhost:8000/api/user", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
  
        const user = response.data;
  
        if (user) {
          isLoggedIn.value = true;
          userid.value = user.id;
          fetchLocations();
        } else {
          isLoggedIn.value = false;
        }
      } else {
        isLoggedIn.value = false;
      }
    } catch (error) {
      console.error(
        "Erreur lors de la récupération des informations de l'utilisateur",
        error
      );
      isLoggedIn.value = false;
    }
  };
  
  const filterLocations = () => {
    if (isLoggedIn.value) {
      filteredLocations.value = Locations.value.filter(
        (location) => location.users.id === userid.value
      );
    } else {
      filteredLocations.value = [];
    }
  };
  const deleteLoc = async (locId) => {
    if (window.confirm("Êtes-vous sûr de vouloir supprimer cette location?")) {
      try {
        // Implement logic for deleting a car
        await axios.delete(`http://localhost:8000/api/locations/${locId}`);
        fetchLocations();
      } catch (error) {
        console.error("Error deleting car:", error);
      }
    }
  };
  
  onMounted(() => {
    fetchUserInfo();
  });
  
  watch(() => Locations.value, filterLocations);
  </script>
  
  <style lang="scss" scoped>
  /* Add styles if necessary */
  </style>
  