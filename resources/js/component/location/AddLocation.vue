<template>
  <nav class="navbar navbar-expand-lg navbar-dark darg">
    <div class="container-fluid">
      <h3>Liste des Locations</h3>
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
    <div class="Locd flex justify-content-center">
      <Dialog v-model:visible="visible">
        <div class="row">
          <div class="col-md-6">
            <label for="date_debut" class="form-label">Date Début</label>
            <input
              type="date"
              class="form-control"
              id="date_debut"
              v-model="Loc.date_debut"
              @input="updatePrice"
            />
          </div>
          <div class="col-md-6 ms-auto">
            <label for="date_fin" class="form-label">Date Fin</label>
            <input
              type="date"
              class="form-control"
              id="date_fin"
              v-model="Loc.date_fin"
              @input="updatePrice"
            />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <label for="prix_total" class="form-label">Prix</label>
            <input
              type="text"
              class="form-control"
              id="prix_total"
              v-model="Loc.prix_total"
              readonly
            />
          </div>
          <div class="col-md-6">
            <label for="voitureID" class="form-label">Voiture</label>
            <select class="form-control" v-model="Loc.voitureID">
                <option value="" disabled>Select a voiture</option>
              <option v-for="v in voitures" :key="v.id" :value="v.id">
                {{ v.matricule }}
              </option>
            </select>
          </div>
        </div>
        <br />
        <button type="button" class="btn btn-outline-primary" @click="fetchUserInfo">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-floppy"
            viewBox="0 0 16 16"
          >
            <path d="M11 2H9v3h2z" />
            <path
              d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"
            />
          </svg>
          Enregistrer
        </button>
        <button type="button" class="btn btn-outline-primary" @click="cancel">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            class="bi bi-x-circle"
            viewBox="0 0 16 16"
          >
            <path
              d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"
            />
            <path
              d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"
            />
          </svg>
          Annuler
        </button>
      </Dialog>
    </div>
  </form>
</template>
<script setup>
import { ref, onMounted ,defineProps} from "vue";
import Dialog from "primevue/dialog";
import axios from "axios";
const { fetchLocations } = defineProps(["fetchLocations"]);
const visible = ref(false);
const voitures = ref([]);
const Loc = ref({
  date_debut: "",
  date_fin: "",
  prix_total: 0, // Prix initialisé à 0
  etat: "En cours", // État par défaut
  voitureID: "",
  userID:"",
});


const isLoggedIn = ref(false);
const userid=ref(null); 
  const fetchUserInfo = async () => {
    try {
      const token = localStorage.getItem('token');
      if (token) {
        const response = await axios.get('http://localhost:8000/api/user', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
  
        const user = response.data;
        if (user) {
          isLoggedIn.value = true;
		userid.value=user.id
    console.log(userid)
    addLoc();

        } else {
          isLoggedIn.value = false;
        }
      } else {
        isLoggedIn.value = false;
      }
    } catch (error) {
      console.error('Erreur lors de la récupération des informations de l\'utilisateur', error);
      isLoggedIn.value = false;
    }
  };
const prixParJour = 100; // Prix par jour (variable fixe à 100)
const updatePrice = () => {
  const dateDebut = new Date(Loc.value.date_debut);
  const dateFin = new Date(Loc.value.date_fin);
  if (dateDebut >= dateFin) {
    
    Loc.value.prix_total = NaN; // Ou une autre valeur par défaut
    return;
  }
  const diffTime = Math.abs(dateFin - dateDebut);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  Loc.value.prix_total = prixParJour * diffDays;
};
const addLoc = async () => {
  try {
    // Vérifier la disponibilité avant d'afficher la boîte de dialogue
    const isAvailable = await checkAvailability();

    // Si la voiture est disponible, procéder à l'ajout de la location
    if (isAvailable) {
      // Calculer la différence de jours entre date_debut et date_fin
      const dateDebut = new Date(Loc.value.date_debut);
      const dateFin = new Date(Loc.value.date_fin);
      const diffTime = Math.abs(dateFin - dateDebut);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      // Calculer le prix total
      Loc.value.prix_total = prixParJour * diffDays;
      Loc.value.userID = userid.value;
      // Ajouter la nouvelle location
      await axios.post("http://localhost:8000/api/locations/",Loc.value);
      visible.value = false;
      await fetchLocations();
      // Réinitialiser les valeurs de Loc après l'ajout
      Loc.value = {
        date_debut: "",
        date_fin: "",
        prix_total: 0,
        etat: "En cours",
        voitureID: "",
        userID:"",
      };
    }
  } catch (error) {
    console.error("Error adding Loc:", error);
  }
};
const checkAvailability = async () => {
  try {
    // Récupérer toutes les locations existantes pour la voiture sélectionnée
    const existingLocs = await axios.get(
      `http://localhost:8000/api/locations/?voitureID=${Loc.value.voitureID}`
    );

    // Dates de début et de fin de la nouvelle location
    const newStartDate = new Date(Loc.value.date_debut);
    const newEndDate = new Date(Loc.value.date_fin);

    // Vérifier si la date_fin est postérieure à la date_debut
    if (newStartDate >= newEndDate) {
      window.alert("La date de fin doit être postérieure à la date de début.");
      return false;
    }

    // Vérifier si la voiture est disponible pour les nouvelles dates
    const isAvailable = existingLocs.data.every((existingLoc) => {
      const existingStartDate = new Date(existingLoc.date_debut);
      const existingEndDate = new Date(existingLoc.date_fin);

      // Vérifier si les dates se chevauchent et concernent la même voiture
      const isOverlap =
        existingLoc.voitureID === Loc.value.voitureID &&
        ((newStartDate >= existingStartDate && newStartDate < existingEndDate) ||
        (newEndDate > existingStartDate && newEndDate <= existingEndDate) ||
        (existingStartDate >= newStartDate && existingStartDate < newEndDate) ||
        (existingEndDate > newStartDate && existingEndDate <= newEndDate));

      // Si il y a chevauchement, la voiture n'est pas disponible
      return !isOverlap;
    });

    if (isAvailable) {
      // Si la voiture est disponible, retourner true
      return true;
    } else {
      // Si la voiture n'est pas disponible, afficher un message d'alerte
      window.alert("La voiture n'est pas disponible pour ces dates.");
      return false;
    }
  } catch (error) {
    console.error("Error checking availability:", error);
    return false;
  }
};
const fetchCars = async () => {
    try {
      const response = await axios.get("http://localhost:8000/api/voitures");
      voitures.value = response.data;

    } catch (error) {
      console.error("Error fetching cars:", error);
    }
  };
  onMounted(() => {
    fetchCars();
  });
const cancel = () => {
  // Réinitialiser les valeurs de Loc après l'annulation
  Loc.value = {
    date_debut: "",
    date_fin: "",
    prix_total: 0,
    etat: "En cours",
    voitureID: "",
    userID:"",
  };
  visible.value = false;
};


</script>
  <style scoped>
  .darg{
    margin-top: 60px;
  }
</style>