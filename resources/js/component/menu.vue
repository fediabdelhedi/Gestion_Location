<template>
    <nav class="navbar navbar-expand-lg bg-dark fixed-top" data-bs-theme="dark">
      <div class="container-fluid">
        <router-link :to="'/'" class="navbar-brand" >MaVoiture</router-link>
  
        <div class="collapse navbar-collapse" id="navbarColor01">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <router-link to="/" class="nav-link">Home</router-link>
            </li>
  
            <!-- Affiche seulement si l'utilisateur n'est pas connecté -->
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link to="/register" class="nav-link">Register</router-link>
            </li>
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link to="/login" class="nav-link">Login</router-link>
            </li>
  
            <!-- Affiche seulement si l'utilisateur est connecté en tant qu'administrateur -->
            <li class="nav-item" v-if="isLoggedIn && isAdmin">
              <router-link to="/voitures" class="nav-link">Voitures</router-link>
            </li>
            <li class="nav-item" v-if="isLoggedIn && isAdmin">
              <router-link to="/locations" class="nav-link">Locations</router-link>
            </li>
            <!-- Affiche seulement si l'utilisateur est connecté en tant qu'utilisateur -->
            <li class="nav-item" v-if="isLoggedIn && !isAdmin">
              <router-link to="/listlocations" class="nav-link">Mes locations</router-link>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-sm-2" type="search" placeholder="Search" />
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
          </form>
          <li class="nav-item" v-if="isLoggedIn">
            <button class="btn btn-secondary my-2 my-sm-0" @click="logout">Logout</button>
            </li>
          
        </div>
      </div>
    </nav>
  </template>
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRouter } from 'vue-router';
  import axios from 'axios';
  
  const router = useRouter();
  const isLoggedIn = ref(false);
  const isAdmin = ref(false);
  
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
  
        console.log('User:', user);
  
        if (user && typeof user === 'object' && 'type' in user) {
          isLoggedIn.value = true;
          isAdmin.value = user.type === 1;
        } else {
          isLoggedIn.value = false;
          isAdmin.value = false;
        }
      } else {
        isLoggedIn.value = false;
        isAdmin.value = false;
      }
    } catch (error) {
      console.error('Erreur lors de la récupération des informations de l\'utilisateur', error);
      isLoggedIn.value = false;
      isAdmin.value = false;
    }
  };
  
  const logout = async () => {
    try {
      const token = localStorage.getItem('token');
      console.log(token);
  
      await axios.post('http://localhost:8000/api/logout', null, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
  
      // Effacez toutes les données de l'utilisateur du localStorage
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      localStorage.removeItem('type');
      localStorage.removeItem('nom');
  
      isLoggedIn.value = false;
      isAdmin.value = false;
      router.push('/');
      await fetchUserInfo();
    } catch (error) {
      console.error('Erreur lors de la déconnexion', error);
      alert(error);
    }
  };
  
  onMounted(async () => {
    // Ensure fetchUserInfo completes before rendering the component
    await fetchUserInfo();
  });
  </script>
  <style>
  /* Ajoutez vos styles ici si nécessaire */
  </style>
