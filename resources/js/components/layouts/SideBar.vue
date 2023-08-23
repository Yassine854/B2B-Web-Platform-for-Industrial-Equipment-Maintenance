<template>
    <navBar></navBar>
    <!-- Admin SideBar -->
  <div class="container-fluid" v-if="role==2">

    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <div
          class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100"
        >


          <hr class="mx-auto" style="width: 70%;">


          <ul
            class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
            id="menu"
          >
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link align-middle px-0">
                <i class="fa-solid fa-gauge fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Dashboard</span>
              </router-link>
            </li>

            <li>
              <router-link to="/users" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-users fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline"
                  >Utilisateurs</span
                ></router-link
              >
            </li>

            <li>
              <router-link to="/products" class="nav-link px-0 align-middle">
                <i class="fa-brands fa-product-hunt fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Produits</span></router-link
              >
            </li>


                    <li>
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                          <i class="fa-solid fa-keyboard fa-lg"></i> <span class="ms-1 d-none d-sm-inline">Types</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <router-link to="/types_industrie" class="nav-link px-0"> <span class="d-none d-sm-inline"></span>Type industrie</router-link>
                            </li>
                            <li>
                                <router-link to="/types_product" class="nav-link px-0"> <span class="d-none d-sm-inline"></span> Type produit</router-link>
                            </li>
                        </ul>
                    </li>

            <li>
              <router-link to="/parc_clients" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-users-between-lines fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Parc Clients</span></router-link
              >
            </li>


            <li>
              <a href="#" class="nav-link px-0 align-middle">
                <i class="fa-brands fa-servicestack fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Interventions</span></a
              >
            </li>

            <li>
              <a href="#" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-bell fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Notifications</span></a
              >
            </li>

            <li>
              <router-link to="/profile" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-user fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Profile</span></router-link
              >
            </li>

            <li>
              <a style="cursor: pointer" @click="logout" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-power-off fa-lg" style="color: #c70000;"></i>
                <span class="ms-1 d-none d-sm-inline">Déconnexion</span></a
              >
            </li>

          </ul>

          <hr />


        </div>
      </div>
      <div class="col py-3" style="background-color: lightgray">
        <slot></slot>
      </div>
    </div>
  </div>
  <!-- End Admin SideBar -->

<!-- Client SideBar -->
<div class="container-fluid" v-if="role === 1 || role === null">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <div
          class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100"
        >


            <!-- <i class="mx-auto" ><img :src="'../storage/img/GSI-logo-PNG.png'" style="width:150px;background-color: white;"></i> -->

          <!-- <hr class="mx-auto" style="width: 70%;"> -->

          <div class="mx-auto" style="display: flex; align-items: center;">
            <img :src="'../storage/img/client.png'" style="width: 40px; margin-right: 5px;">
            <span style="font-family: 'Raleway', sans-serif; font-size: 16px;">{{ name }}</span>
            </div>


          <hr class="mx-auto" style="width: 70%;">


          <ul
            class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
            id="menu"
          >
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link align-middle px-0">
                <i class="fa-solid fa-gauge fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Dashboard</span>
              </router-link>
            </li>

            <li>
              <a href="#" class="nav-link px-0 align-middle">
                <i class="fa-brands fa-servicestack fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Interventions</span></a
              >
            </li>

            <li>
              <a href="#" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-bell fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Notifications</span></a
              >
            </li>

            <li>
              <router-link to="/profile" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-user fa-lg"></i>
                <span class="ms-1 d-none d-sm-inline">Profile</span></router-link
              >
            </li>

            <li>
              <a style="cursor: pointer" @click="logout" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-power-off fa-lg" style="color: #c70000;"></i>
                <span class="ms-1 d-none d-sm-inline">Déconnexion</span></a
              >
            </li>

          </ul>

          <hr />


        </div>
      </div>
      <div class="col py-3" style="background-color: lightgray">
        <slot></slot>
      </div>
    </div>
  </div>
<!-- End Client SideBar -->
</template>
<script setup>
import navBar from "./navBar";
</script>
<script>
export default {
  name: "SideBar",
  data() {
    return {
      name: null,
      role:"",
    };
  },
  created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
      this.role = window.Laravel.user.role;
    }
  },
  beforeRouteEnter(to, from, next) {
    if (!window.Laravel.isLoggedin) {
      window.location.href = "/";
    }
    next();
  },
  methods: {
    logout(e) {
      e.preventDefault();
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("/api/logout")
          .then((response) => {
            if (response.data.success) {
              window.location.href = "/login";
            } else {
              console.log(response);
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
};
</script>
<style>

#userDropdown {
  position: fixed;
  bottom: 5px;
}

/* Adjusting the width of the dropdown menu */
.dropdown-menu {
  min-width: 200px;
}

/* Styling for the dropdown menu */
.dropdown-menu-dark {
  background-color: #343a40;
}
</style>
