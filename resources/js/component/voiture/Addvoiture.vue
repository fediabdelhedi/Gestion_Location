<template>
    <nav class="navbar navbar-expand-lg navbar-dark darg">
      <div class="container-fluid">
        <h3>Liste des voitures</h3>
        <button
          type="button"
          class="btn btn-warning rounded-circle ms-auto"
          @click="visible = true"
        >
        <svg
        xmlns="http://www.w3.org/2000/svg"
        width="16"
        height="16"
        fill="currentColor"
        class="bi bi-file-plus"
        viewBox="0 0 16 16"
      >
        <path
          d="M8.5 6a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5z"
        />
        <path
          d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1"
        />
      </svg>
          Ajouter
        </button>
      </div>
    </nav>
    <form>
      <div class="card flex justify-content-center">
        <Dialog v-model:visible="visible">
          <div class="row">
            <div class="col-md-6">
              <label for="matricule" class="form-label">Matricule</label>
              <input
                type="text"
                class="form-control"
                id="matricule"
                v-model="Car.matricule"
              />
            </div>
            <div class="col-md-6 ms-auto">
              <label for="marque" class="form-label">Marque</label>
              <input
                type="text"
                class="form-control"
                id="marque"
                v-model="Car.marque"
              />
            </div>
          </div>
        
          <div class="row">
            <div class="col-md-6">
              <label for="modele" class="form-label">Modèle</label>
              <input
                type="text"
                class="form-control"
                id="modele"
                v-model="Car.model"
              />
            </div>
            <div class="col-md-6 ms-auto">
              <label for="couleur" class="form-label">Couleur</label>
              <input
                type="text"
                class="form-control"
                id="couleur"
                v-model="Car.couleur"
              />
            </div>
          </div>
        
          <div class="row">
            <div class="col-md-6">
              <label for="dateFabrication" class="form-label">Date de Fabrication</label>
              <input
                type="date"
                class="form-control"
                id="dateFabrication"
                v-model="Car.date_fabrication"
              />
            </div>
            <div class="col-md-6 ms-auto">
              <label for="prix" class="form-label">Prix</label>
              <input
                type="number"
                class="form-control"
                id="prix"
                v-model="Car.prix"
              />
            </div>
          </div>
        
          <br />
          <button
            type="submit"
            class="btn btn-outline-primary"
            @click="addCar"
          >
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
  <path d="M11 2H9v3h2z"/>
  <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
</svg>
            Enregistrer
          </button>
          <button
            type="button"
            class="btn btn-outline-primary"
            @click="cancel"
          >
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg>
            Annuler
          </button>
        </Dialog>      
      </div>
    </form>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import Dialog from "primevue/dialog";
  import axios from "axios";
  
  const visible = ref(false);
  
  const Car = ref({
    matricule: "",
    marque: "",
    model:"",
    couleur:"",
    date_fabrication:"",
    prix:""
  });
  
  const cars = ref([]);
  const isLoading = ref(true);
  
  
  
  const addCar = async () => {
  try {
    // Fetch existing cars
    const existingCars = await axios.get("http://localhost:8000/api/voitures/");

    // Check if the new car already exists
    const isCarExists = existingCars.data.some(
      (existingCars) => existingCars.matricule === Car.value.matricule
    );

    if (isCarExists) {
      // Handle the case where the car already exists
      window.alert("Car already exists!");
     
    
    } else {
      // Add the new car if it doesn't exist
      await axios.post("http://localhost:8000/api/voitures/", Car.value);
      visible.value = false;
      await fetchCars();
      Car.value = {
        matricule: "",
    marque: "",
    model:"",
    couleur:"",
    date_fabrication:"",
    prix:""
      };
    }
  } catch (error) {
    console.error("Error adding car:", error);
  }
};
  

  onMounted(() => {
    fetchCars();
  });
  
  const cancel = () => {
    Car.value = {
        matricule: "",
    marque: "",
    model:"",
    couleur:"",
    date_fabrication:"",
    prix:""
      };
    
    visible.value = false;
  };
  const { fetchCars } = defineProps(["fetchCars"]);
  </script>
  
  <style scoped>
  .darg{
    margin-top: 60px;
  }
  </style>