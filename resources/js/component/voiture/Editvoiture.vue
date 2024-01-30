<template>
    <button
      type="button"
      class="btn btn-warning"
      @click="visible = true"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg>
    </button>
    <form @submit.prevent>
      <div class="card flex justify-content-center">
        <Dialog v-model:visible="visible">
          <div class="row">
            <div class="col-md-6">
              <label for="matricule" class="form-label">Matricule</label>
              <input
                type="text"
                class="form-control"
                id="matricule"
                v-model="car.matricule"
              />
            </div>
            <div class="col-md-6 ms-auto">
              <label for="marque" class="form-label">Marque</label>
              <input
                type="text"
                class="form-control"
                id="marque"
                v-model="car.marque"
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
                v-model="car.model"
              />
            </div>
            <div class="col-md-6 ms-auto">
              <label for="couleur" class="form-label">Couleur</label>
              <input
                type="text"
                class="form-control"
                id="couleur"
                v-model="car.couleur"
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
                v-model="car.date_fabrication"
              />
            </div>
            <div class="col-md-6 ms-auto">
              <label for="prix" class="form-label">Prix</label>
              <input
                type="number"
                class="form-control"
                id="prix"
                v-model="car.prix"
              />
            </div>
          </div>
        
          <br />
          <button
            type="submit"
            class="btn btn-outline-primary"
            @click="modifierCar"
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
  import { ref, defineProps ,onMounted} from "vue";
  import Dialog from "primevue/dialog";
  import axios from "axios";
  
  const visible = ref(false);
  const car = ref({
    matricule: "",
    marque: "",
    model:"",
    couleur:"",
    date_fabrication:"",
    prix:""
  });
  const loadcar = () => {
  console.log(props.car);
  car.value = props.car;
};
onMounted(() => {
  loadcar();
});
const props = defineProps(["car", "fetchCars"]);
  const modifierCar = () => {
    // Modify the API endpoint as needed
     axios
      .put(`http://localhost:8000/api/voitures/${car.value.id}`, car.value)
      .then(() => {
        visible.value = false;
        props.fetchCars()
           
      })
      .catch((error) => {
        console.error("There was an error!", error);
      });
  };
  
  const cancel = () => {
    visible.value = false;
  };
  
  </script>
  
  <style scoped>
  </style>