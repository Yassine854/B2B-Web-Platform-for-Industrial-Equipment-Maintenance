<template>
    <!-- Admin Dashboard -->
    <SideBar v-if="checkLoginAdmin()">
        <div >
            welcome to your dashboard admin
        </div>
    </SideBar>

    <!-- Client Dashboard -->
    <SideBar v-else>
        <div v-if="checkClientVerification()">
            Bienvenue dans votre dashboard
        </div>
        <div v-else>
            <div class="alert alert-warning" role="alert">
                Votre e-mail est en attente de vérification.<br>Veuillez vous assurer de remplir les informations requises ci-dessous!
            </div>

            <div class="container-xl px-4 mt-4">
    <div class="row">

        <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Détails du compte</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)-->
                        <!-- <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Nom et Prénom</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Entrer votre nom et pénom">
                        </div> -->
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Société</label>
                                <input class="form-control" id="inputFirstName" type="text" placeholder="Entrer le nom de votre société" >
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Type industrie</label>
                                <select class="form-select" id="inputLastName" aria-label="Default select example">
                                <option ></option>
                                </select>
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName" >Résponsable</label>
                                <input class="form-control" id="inputOrgName" type="text" placeholder="Entrer le nom du répsponsable" >
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Numéro du résponsable</label>
                                <input class="form-control" id="inputLocation" type="text" placeholder="Entrer le numéro du répsponsable" >
                            </div>
                        </div>
                        <SelectCountryStateCity/>

                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Adresse</label>
                            <textarea class="form-control" id="inputUsername" rows="4" placeholder="Entrer votre adresse"></textarea>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </SideBar>
  </template>

<script setup>
import SideBar from '../components/layouts/SideBar.vue'; // Update the import statement
import { checkLoginStatus,checkLoginAdmin,checkClientVerification } from '../auth'; // Import the checkLoginStatus function
import SelectCountryStateCity from "../pages/SelectCountryStateCity.vue";
</script>

<script >
export default {
  name: "Dashboard",
  //check auth
  beforeRouteEnter(to, from, next) {
    if (checkLoginStatus()) {
      next();
    } else {
      next('/login');
    }
  },
  data() {
            return {
                role: null,
            }
        },
        created() {
            if (window.Laravel.user) {
                this.role = window.Laravel.user.role
                console.log("user's role is "+this.role);
            }
        },
        methods:{
            isAdmin() {
                return this.role === 2;
            },
},
props: {
    // country
    countryLabel: {
      type: String,
      default: "Choose your country :",
    },
}
}
</script>
