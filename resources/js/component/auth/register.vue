<template>
  <div class="wallpaper-register"></div>
  <div class="marge">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Register</div>
          <div class="card-body">
            <form>
              <div class="form-group row">
                <label for="nom" class="col-sm-4 col-form-label text-md-right"
                  >Nom</label
                >
                <div class="col-md-6">
                  <input
                    id="nom"
                    type="text"
                    class="form-control"
                    v-model="user.nom"
                    required
                    autofocus
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="prenom" class="col-sm-4 col-form-label text-md-right"
                  >Prénom</label
                >
                <div class="col-md-6">
                  <input
                    id="prenom"
                    type="text"
                    class="form-control"
                    v-model="user.prenom"
                    required
                    autofocus
                    autocomplete="off"
                  />
                </div>
              </div>
<div class="form-group row">
                <label for="telephone" class="col-sm-4 col-form-label text-md-right"
                  >Telephone</label
                >
                <div class="col-md-6">
                  <input
                    id="telephone"
                    type="text"
                    class="form-control"
                    v-model="user.telephone"
                    required
                    autofocus
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label text-md-right"
                  >E-Mail Address</label
                >
                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="user.email"
                    required
                    autofocus
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Password</label
                >
                <div class="col-md-6">
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="user.password"
                    required
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >Password Confirmation</label
                >
                <div class="col-md-6">
                  <input
                    id="password_confirmation"
                    type="password"
                    class="form-control"
                    v-model="user.password_confirmation"
                    required
                    autocomplete="off"
                  />
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click="handleSubmit"
                  >
                    Register
                  </button>
                </div>
              </div>
            </form>
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
const handleSubmit = async () => {
  axios
    .post("http://localhost:8000/api/register/",user)
    .then((response) => {
      console.log(response);
      router.replace({ name: "login" });
    })
    .catch((err) => {
      console.log(err);
      alert(err);
    });
};
</script>
    <style scoped>
    .wallpaper-register {
  background: url(https://res.cloudinary.com/dfpoxryjv/image/upload/v1705499149/585971ba3afef8ae4883d41a095c6f22_i28qa3.jpg) no-repeat center center;
  background-size: cover;
  height: 100%;
  position: absolute;
  width: 100%;
}
    .marge {
      position: fixed;
      width: 70%;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      border: 10px solid #ccc;
      background-color: #fff;
      overflow-y: auto; /* Add this for scrolling if the content exceeds the height */
      max-height: 80vh; /* Limit maximum height */
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
    
    .btn-primary {
      background-color: #3498db;
      border: none;
    }
    
    .btn-primary:hover {
      background-color: #2980b9;
    }
</style>