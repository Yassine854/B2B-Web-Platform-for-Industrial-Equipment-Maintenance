<template>


  <!-- Admin Dashboard -->
  <layout v-if="checkLoginAdmin()">
    <div>welcome to your dashboard admin</div>
  </layout>


  <!-- End Admin Dashboard -->

  <!-- Client Dashboard verified -->
  <layout v-else>
    <div v-if="checkClientVerification()">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      </div>

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Parc client</h6>
        </div>

        <div class="card-body">
          <div class="px-lg-5">
            <div class="row">
              <!-- v-for loop to iterate over assignments -->
              <div
                class="col-xl-3 col-lg-4 col-md-6 mb-4"
                v-for="assignment in ClientAssignments"
                :key="assignment.id"
              >
                <div
                  class="bg-white rounded shadow-sm d-flex flex-column align-items-center justify-content-center " @click="openShowModal(assignment)" style="cursor: pointer;"
                >
                  <img
                    :src="'/storage/img/pompes/' + assignment.product[0].image"
                    alt=""
                    class="img-fluid card-img-top"
                    style="height: 150px; width: 150px"
                  />
                  <div class="p-4">
                    <h5 class="text-dark">{{ assignment.product[0].name }}</h5>
                    <p class="small text-muted mb-0">
                      Code GSI :<b>{{ assignment.product[0].id }}</b>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Client not submitted -->
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

    <!-----------------------------------------------show Assignment------------------------------------------>

    <div class="modal fade" id="showAssignment" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <div class="d-flex align-items-center">
              <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px"></i>
              <h5 class="modal-title mb-0" id="showAssignmentLabel">
                Détails du parc
              </h5>
            </div>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row gx-3 mb-3">
                <div class="col-md-8">

                  <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                      <label class="small mb-1" for="debit" style="float: left"
                        >Changement d'huile</label
                      >
                      <input
                        class="form-control"
                        id="debit"
                        type="text"
                        v-model="c_huileShow"
                        disabled
                      />
                    </div>
                    <div class="col-md-6">
                      <label
                        class="small mb-1"
                        for="pression"
                        style="float: left"
                        >Changement des cartouches de filtres</label
                      >
                      <input
                        class="form-control"
                        id="pression"
                        type="text"
                        v-model="c_filtreShow"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                      <label class="small mb-1" for="annee" style="float: left"
                        >Changement des déshuileurs</label
                      >
                      <input
                        class="form-control"
                        id="annee"
                        type="text"
                        v-model="c_dehuilShow"
                        disabled
                      />
                    </div>
                    <div class="col-md-6">
                      <label
                        class="small mb-1"
                        for="time_day"
                        style="float: left"
                        >Entretien Génerale</label
                      >
                      <input
                        class="form-control"
                        id="time_day"
                        type="text"
                        v-model="entretienShow"
                        disabled
                      />
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div
                    class="d-flex align-items-center justify-content-center h-100"
                  >
                  <div class="image shadow">
                  <img :src="'/storage/img/pompes/' + imageShow" class="centered-image img-fluid" />
                </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!----------------------------------------------- End show Assignment------------------------------------------>
  </layout>
<!-- End client verified -->

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
let ClientAssignments = ref([]);
let ClientId = window.Laravel.user.id;
onMounted(async () => {
  get_all_types();
  get_client_assignments();
});

const get_all_types = async () => {
  try {
    let response = await axios.get("/api/get_type_industries");
    console.log(response.data);
    type_industries.value = response.data.type_industries;
  } catch (error) {
    console.error(error);
  }
};

const get_client_assignments = async () => {
  try {
    let response = await axios.get(`/api/get_client_assignments/${ClientId}`);
    console.log(response.data);
    ClientAssignments.value = response.data.ClientAssignments;
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

      //Show assignment
      c_huileShow:"",
      c_filtreShow:"",
      c_dehuilShow:"",
      entretienShow:"",
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
    if (
      this.society &&
      this.type_ind &&
      this.responsable &&
      this.N_responsable &&
      this.selectedCountry &&
      this.selectedState &&
      this.address
    )
      this.formSubmitted = true;
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

openShowModal(assignment) {
  try {
    this.imageShow = assignment.product[0].image;
    var today = new Date();
    // this.c_huileShow = assignment.c_huile;
    // this.c_filtreShow = assignment.c_filtre;
    // this.c_dehuilShow = assignment.c_dehuil;
    // this.entretienShow = assignment.entretien;

    //updatables
    const huilDate = assignment.c_huile / assignment.product[0].time_day;
    const c_huileDate = new Date(today.getTime() + (huilDate * 24 * 60 * 60 * 1000));
    this.c_huileShow = c_huileDate.toLocaleDateString('fr-FR');

    const filtreDate = assignment.c_filtre / assignment.product[0].time_day;
    const c_filtreDate = new Date(today.getTime() + (filtreDate * 24 * 60 * 60 * 1000));
    this.c_filtreShow = c_filtreDate.toLocaleDateString('fr-FR');

    const dehuilDate = assignment.c_dehuil / assignment.product[0].time_day;
    const c_dehuilDate = new Date(today.getTime() + (dehuilDate * 24 * 60 * 60 * 1000));
    this.c_dehuilShow = c_dehuilDate.toLocaleDateString('fr-FR');

    const entretienHours = assignment.entretien;
    const millisecondsInAnHour = 60 * 60 * 1000;
    const entretienDate = new Date(today.getTime() + (entretienHours * millisecondsInAnHour));
    this.entretienShow = entretienDate.toLocaleDateString('fr-FR');

    $("#showAssignment").modal("show");
  } catch (error) {
    console.error(error);
  }
}



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
