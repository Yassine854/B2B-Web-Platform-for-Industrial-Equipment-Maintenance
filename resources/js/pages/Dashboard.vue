<template>
  <!-- Admin Dashboard -->
  <layout v-if="checkLoginAdmin()">
    <div>welcome to your dashboard admin</div>
  </layout>

  <!-- Client Dashboard -->
  <layout v-else >
    <div v-if="checkClientVerification()">Bienvenue dans votre dashboard</div>




    <div v-else-if="!formSubmitted">
      <div class="alert alert-warning" role="alert">
        Votre e-mail est en attente de vérification.<br />Veuillez vous assurer
        de remplir les informations requises ci-dessous!
      </div>

      <div class="container-xl px-4 mt-4">
        <div class="row">
          <div class="col-xl-12">
            <!-- Account details card-->
            <div class="card mb-4">
              <div class="card-header">Détails du compte</div>
              <div class="card-body">
                <form @submit.prevent="updateClientDetails(user)">
                  <!-- Form Group (username)-->
                  <!-- <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Nom et Prénom</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Entrer votre nom et pénom">
                        </div> -->
                  <!-- Form Row-->
                  <div class="row gx-3 mb-3">
                    <!-- Form Group (first name)-->
                    <div class="col-md-6">
                      <label class="small mb-1" for="inputFirstName"
                        >Société</label
                      >
                      <input
                        class="form-control"
                        id="inputFirstName"
                        type="text"
                        placeholder="Entrer le nom de votre société"
                        v-model="society"
                        required
                      />
                    </div>
                    <!-- Form Group (last name)-->
                    <div class="col-md-6">
                      <label
                        class="small mb-1"
                        for="inputLastName"
                        style="float: left"
                        >Type industrie</label
                      >
                      <select
                        class="form-select"
                        id="inputLastName"
                        aria-label="Default select example"
                        v-model="type_ind"
                        required
                      >
                        <option
                          v-for="industrie in type_industries"
                          :key="industrie.id"
                          :value="industrie.id"
                        >
                          {{ industrie.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <!-- Form Row        -->
                  <div class="row gx-3 mb-3">
                    <!-- Form Group (organization name)-->
                    <div class="col-md-6">
                      <label class="small mb-1" for="inputOrgName"
                        >Résponsable</label
                      >
                      <input
                        class="form-control"
                        id="inputOrgName"
                        type="text"
                        placeholder="Entrer le nom du répsponsable"
                        v-model="responsable"
                        required
                      />
                    </div>
                    <!-- Form Group (location)-->
                    <div class="col-md-6">
                      <label class="small mb-1" for="inputLocation"
                        >Numéro du résponsable</label
                      >
                      <input
                        class="form-control"
                        id="inputLocation"
                        type="text"
                        placeholder="Entrer le numéro du répsponsable"
                        v-model="N_responsable"
                        required
                      />
                    </div>
                  </div>

                  <!-- Country & state Add  -->
                  <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                      <label for="country" style="float: left">Pays</label>
                      <select
                        class="form-select"
                        v-model="selectedCountry"
                        @change="fireState()"
                        required
                      >
                        <option selected hidden>Open this select menu</option>
                        <option
                          :value="country.id"
                          v-for="country in countries"
                          :key="country.id"
                        >
                          {{ country.name }}
                        </option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="country" style="float: left"
                        >Gouvernorat</label
                      >
                      <select
                        class="form-select"
                        :disabled="selectedCountry == ''"
                        v-model="selectedState"
                        required
                      >
                        <option hidden selected>Open this select menu</option>
                        <option
                          :value="state.id"
                          v-for="state in states"
                          :key="state.id"
                        >
                          {{ state.name }}
                        </option>
                      </select>
                    </div>
                  </div>

                  <!-- Form Group (username)-->
                  <div class="mb-3">
                    <label class="small mb-1" for="inputUsername"
                      >Adresse</label
                    >
                    <textarea
                      class="form-control"
                      id="inputUsername"
                      rows="4"
                      placeholder="Entrer votre adresse"
                      v-model="address"
                      required
                    ></textarea>
                  </div>
                  <!-- Save changes button-->
                  <button class="btn btn-primary" type="submit">
                    Enregistrer
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="formSubmitted">
        <div class="alert alert-info" role="alert">
            Votre e-mail est en attente de vérification.
    </div>
    </div>


</layout>
</template>

<script setup>
import { onMounted, ref, computed } from "vue";
import layout from "../components/layouts/layout.vue";
import {
  checkLoginStatus,
  checkLoginAdmin,
  checkClientVerification,
} from "../auth"; // Import the checkLoginStatus function
import listCountries from "../../json/country.json";
import listStates from "../../json/state.json";
import Swal from "sweetalert2";

let type_industries = ref([]);

onMounted(async () => {
  get_all_types();
});

const get_all_types = async () => {
  try {
    let response = await axios.get("/api/get_type_industries");
    console.log(response.data); // Log the response data
    type_industries.value = response.data.type_industries;
  } catch (error) {
    console.error(error);
  }
};
</script>

<script >
export default {
  name: "Dashboard",
  //check auth
  beforeRouteEnter(to, from, next) {
    if (checkLoginStatus()) {
      next();
    } else {
      next("/login");
    }
  },
  data() {
    return {
      formSubmitted: false,
      user: {},
      role: null,
      id: "",
      society: "",
      type_ind: "",
      responsable: "",
      N_responsable: "",
      countries: listCountries,
      selectedCountry: "",
      selectedState: "",
      states: [],
      address: "",
    };
  },
  created() {
    if (window.Laravel.user) {
    this.user = window.Laravel.user;
    this.role = window.Laravel.user.role;
    this.id = window.Laravel.user.id;
    console.log("user's role is " + this.role);
    console.log("user's id is " + this.id);
    //Client
    this.society = window.Laravel.user.society;
    this.type_ind = window.Laravel.user.type_ind;
    this.responsable = window.Laravel.user.responsable;
    this.N_responsable = window.Laravel.user.N_responsable;
    this.selectedCountry = window.Laravel.user.country;
    this.selectedState = window.Laravel.user.city;
    this.address = window.Laravel.user.address;
    }
    if (this.society && this.type_ind && this.responsable && this.N_responsable && this.selectedCountry && this.selectedState && this.address)
        this.formSubmitted=true;
  },
  methods: {
    isAdmin() {
      return this.role === 2;
    },
    fireState() {
      this.states = [];
      this.states = listStates.filter(
        (state) => state.country_id === this.selectedCountry
      );
    },

    updateClientDetails(user) {
      console.log("user name:" + user.name);
      try {
        axios.put(`/api/users/requestVerification/${user.id}`, {
          society: this.society,
          type_ind: this.type_ind,
          responsable: this.responsable,
          N_responsable: this.N_responsable,
          country: this.selectedCountry,
          city: this.selectedState,
          address: this.address,
        });

        this.society = "";
        this.type_ind = "";
        this.responsable = "";
        this.N_responsable = "";
        this.selectedCountry = "";
        this.selectedState = "";
        this.address = "";
        this.formSubmitted = true;

        const toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          customClass: {
            popup: "colored-toast",
          },
          timer: 3000,
        });
        toast.fire({
          icon: "success",
          title: " succés!",
        });

        this.$router.push("/dashboard");
      } catch (error) {
        console.log(error);
      }
    },
  },
  props: {
    // country
    countryLabel: {
      type: String,
      default: "Choose your country :",
    },
  },
};
</script>
