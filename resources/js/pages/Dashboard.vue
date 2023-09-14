<template>
  <!-- Admin Dashboard -->
  <layout v-if="checkLoginAdmin()">
    <div class="row">
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                >
                  Clients
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  {{ clientCount }}
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-success text-uppercase mb-1"
                >
                  Interventions
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  {{ interventionCount }}
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-info text-uppercase mb-1"
                >
                  Diagnostics
                </div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                      {{ diagnosticCount }}
                    </div>
                  </div>
                  
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                >
                  Notifications
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  {{ notificationCount }}
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
          class="bg-white rounded shadow-sm d-flex flex-column align-items-center justify-content-center"
          @click="openShowModal(assignment)"
          style="cursor: pointer"
        >
          <img
            :src="'/storage/img/pompes/' + assignment.product[0].image"
            alt=""
            class="img-fluid card-img-top"
            style="height: 150px; width: 150px"
          />
          <div class="p-4">
            <!-- Use the text-truncate class to handle long product names -->
            <h5 class="text-dark text-truncate">{{ assignment.product[0].name }}</h5>
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
                        v-model="type_ind"
                        required
                      >
                        <option value="" disabled selected>
                          Sélectionner le type d'industrie
                        </option>
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
                        <option value="" disabled selected>
                          Sélectionner le pays
                        </option>

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
                        <option value="" disabled selected>
                          Sélectionner le gouvernorat
                        </option>
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
      <div class="modal-dialog modal-dialog-centered modal-xl">
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
              <div class="row">
                <div class="col-md-8">
                  <!-- Pump Information -->
                  <div class="mb-3">
                    <label class="small mb-1" for="name">Pompe</label>
                    <div class="input-group">
                      <input
                        class="form-control"
                        id="name"
                        type="text"
                        v-model="productShow"
                        disabled
                      />
                    </div>
                  </div>
                  <!-- Maintenance Sections -->
                  <div class="row">
                    <div class="col-md-6" v-if="c_huileShow">
                      <div class="mb-3">
                        <label class="small mb-1" for="c_huileShow"
                          >Changement d'huile</label
                        >
                        <div class="input-group">
                          <input
                            v-if="isDateInPast(c_huileShow)"
                            class="form-control bg-danger text-white"
                            id="debit"
                            type="text"
                            value="Il faut changer l'huile."
                            readonly
                          />
                          <input
                            v-else
                            class="form-control"
                            id="c_huileShow"
                            type="text"
                            :value="formatDateToFrench(c_huileShow)"
                            disabled
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6" v-if="c_filtreShow">
                      <div class="mb-3">
                        <label class="small mb-1" for="c_filtreShow"
                          >Changement des cartouches de filtres</label
                        >
                        <div class="input-group">
                          <input
                            v-if="isDateInPast(c_filtreShow)"
                            class="form-control bg-danger text-white"
                            id="pression"
                            type="text"
                            value="Il faut changer les cartouches de filtres."
                            readonly
                          />
                          <input
                            v-else
                            class="form-control"
                            id="c_filtreShow"
                            type="text"
                            :value="formatDateToFrench(c_filtreShow)"
                            disabled
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6" v-if="c_dehuilShow">
                      <div class="mb-3">
                        <label class="small mb-1" for="c_dehuilShow"
                          >Changement des déshuileurs</label
                        >
                        <div class="input-group">
                          <input
                            v-if="isDateInPast(c_dehuilShow)"
                            class="form-control bg-danger text-white"
                            id="annee"
                            type="text"
                            value="Il faut changer les déshuileurs."
                            readonly
                          />
                          <input
                            v-else
                            class="form-control"
                            id="c_dehuilShow"
                            type="text"
                            :value="formatDateToFrench(c_dehuilShow)"
                            disabled
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6" v-if="entretienShow">
                      <div class="mb-3">
                        <label class="small mb-1" for="entretienShow"
                          >Entretien Génerale</label
                        >
                        <div class="input-group">
                          <input
                            v-if="isDateInPast(entretienShow)"
                            class="form-control bg-danger text-white"
                            id="time_day"
                            type="text"
                            value="Entretien a été dépassé."
                            readonly
                          />
                          <input
                            v-else
                            class="form-control"
                            id="entretienShow"
                            type="text"
                            :value="formatDateToFrench(entretienShow)"
                            disabled
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <!-- Pump Image -->
                  <div
                    class="d-flex align-items-center justify-content-center h-100"
                  >
                    <div class="image shadow">
                      <img
                        :src="'/storage/img/pompes/' + imageShow"
                        class="centered-image img-fluid"
                      />
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
      clientCount: 0,
      interventionCount: 0,
      diagnosticCount:0,
      notificationCount: 0,

      //Show assignment
      c_huileShow: "",
      c_filtreShow: "",
      c_dehuilShow: "",
      entretienShow: "",
      productShow: "",
    };
  },
  mounted() {
    this.fetchClientCount();
    this.fetchInterventionCount();
    this.fetchDiagnosticCount();
    this.fetchNotificationCount();

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
      this.productShow = "";
      this.imageShow = "";
      this.c_huileShow = "";
      this.c_filtreShow = "";
      this.c_dehuilShow = "";
      this.entretienShow = "";
      try {
        this.productShow = assignment.product[0].name;
        this.imageShow = assignment.product[0].image;
        var today = new Date();
        // this.c_huileShow = assignment.c_huile;
        // this.c_filtreShow = assignment.c_filtre;
        // this.c_dehuilShow = assignment.c_dehuil;
        // this.entretienShow = assignment.entretien;

        //updatables
        if (assignment.c_huile) {
          this.c_huileShow = new Date(assignment.updated_c_huile);
        }
        if (assignment.c_filtre) {
          this.c_filtreShow = new Date(assignment.updated_c_filtre);
        }
        if (assignment.c_dehuil) {
          this.c_dehuilShow = new Date(assignment.updated_c_dehuil);
        }
        if (assignment.entretien) {
          this.entretienShow = new Date(assignment.updated_entretien);
        }

        $("#showAssignment").modal("show");
      } catch (error) {
        console.error(error);
      }
    },
    formatDateToFrench(date) {
      const day = date.getDate().toString().padStart(2, "0");
      const month = (date.getMonth() + 1).toString().padStart(2, "0");
      const year = date.getFullYear();

      return `${day}/${month}/${year}`;
    },

    isDateInPast(dateString) {
      // Convert the input date string to a Date object
      const inputDate = new Date(dateString);

      // Get the current date
      const currentDate = new Date();

      // Compare the dates
      return inputDate <= currentDate;
    },

    fetchClientCount() {
      axios
        .get("/api/get-client-count")
        .then((response) => {
          this.clientCount = response.data.clientCount;
        })
        .catch((error) => {
          console.error("Error fetching client count:", error);
        });
    },

    fetchInterventionCount() {
      axios
        .get("/api/get-intervention-count")
        .then((response) => {
          this.interventionCount = response.data.interventionCount;
        })
        .catch((error) => {
          console.error("Error fetching intervention count:", error);
        });
    },

    fetchDiagnosticCount() {
      axios
        .get("/api/get-diagnostic-count")
        .then((response) => {
          this.diagnosticCount = response.data.diagnosticCount;
        })
        .catch((error) => {
          console.error("Error fetching diagnostic count:", error);
        });
    },

    fetchNotificationCount() {
      axios
        .get("/api/get-notification-count")
        .then((response) => {
          this.notificationCount = response.data.notificationCount;
        })
        .catch((error) => {
          console.error("Error fetching notification count:", error);
        });
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
