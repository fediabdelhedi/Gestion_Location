<template>
  <div class="login-page">
    <div class="wallpaper-login"></div>
    <div class="marge">
      <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Adjusted column width -->
          <div class="card card-default">
            <div class="card-header">
              <h1 class="text-center">Login</h1> <!-- Centered login header -->
            </div>
            <div class="card-body">
              <form @submit.prevent="handleLogin">
                <div class="form-group row">
                  <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label> <!-- Adjusted label text -->
                  <div class="col-md-8"> <!-- Adjusted column width -->
                    <input id="email" type="email" class="form-control" v-model="user.email" required autofocus autocomplete="off">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                  <div class="col-md-8">
                    <input id="password" type="password" class="form-control" v-model="user.password" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group row mb-0">
                  <div class="col-md-12 text-center"> <!-- Adjusted column width and centered button -->
                    <button type="submit" class="btn btn-primary btn-sm">Login</button> <!-- Added btn-sm for a smaller button -->
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
let user = {};

const handleLogin = async () => {
  try {
    const response = await axios.post("http://localhost:8000/api/login/", user);

    console.log("Response:", response.data); // Ajout de ce log

    const userData = response.data.user;

    localStorage.setItem("user", JSON.stringify(userData));
    localStorage.setItem("type", userData.type);
    localStorage.setItem("token", response.data.token);
    localStorage.setItem("nom", userData.nom);

    router.push("/");
  } catch (error) {
    console.error(error);
    alert("Login failed. Please check your credentials.");
  }
};
</script>
<style scoped>


.wallpaper-login {
  background: url(https://res.cloudinary.com/dfpoxryjv/image/upload/v1705499149/585971ba3afef8ae4883d41a095c6f22_i28qa3.jpg) no-repeat center center;
  background-size: cover;
  height: 100%;
  position: absolute;
  width: 100%;
}

.marge {
  position: fixed;
  width: 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
  border: 5px solid #ccc;
  background-color: #fff;
}

.card-default {
  border-radius: 10px;
}

.card-body {
  padding: 5px;
}

.form-group {
  margin-bottom: 20px;
}

.card {
  padding: 15px; /* Adjusted padding */
  border-radius: 8px; /* Rounded corners */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Added box shadow for depth */
}

h1 {
  margin-bottom: 1.5rem;
}



</style>