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
                <i class="fa-solid fa-users fa-2x text-gray-300"></i>
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
                <i class="fas fa-screwdriver-wrench fa-2x text-gray-300"></i>
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

    <div class="row">

<div class="col-xl-8 col-lg-7">

    <!-- Area Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Intervention par client</h6>
        </div>
        <div class="card-body">
            <div class="chart-bar">
                <canvas ref="clientsBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Intervention par mois</h6>
        </div>
        <div class="card-body">
            <div class="chart-bar">
                <canvas ref="MonthlyBarChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Donut Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Répartition des interventions</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4">
                <canvas ref="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
  </layout>

  <!-- End Admin Dashboard -->

  <!-- Client Dashboard verified -->
  <layout v-else>
    <div v-if="checkClientVerification() && !checkClientDisabled()">
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
          style="cursor: pointer;height:300px;"
        >
          <img v-if="assignment.product[0].image"
            :src="'/storage/img/pompes/' + assignment.product[0].image"
            alt=""
            class="img-fluid card-img-top"
            style="height: 150px; width: 150px"
          />
          <img v-else
            :src="'/storage/img/NoImage.png'"
            alt=""
            class="img-fluid card-img-top"
            style="height: 150px; width: 150px"
          />
          <div class="p-4">
    <h5 class="text-dark ">{{ assignment.product[0].name }}</h5>
    <p class="small text-muted ">
        Code GSI : <b>{{ assignment.product[0].id }}</b>
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
                        :class="['form-control', {'is-invalid': validationErrorsEdit.society}]"
                          id="inputFirstName"
                          type="text"
                          placeholder="Entrer le nom de votre société"
                          v-model="society"

                        />
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.society" :key="index">{{ err }}<br></span>

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
                        :class="['form-select', {'is-invalid': validationErrorsEdit.type_ind}]"
                          id="inputLastName"
                          aria-label="Default select example"
                          v-model="type_ind"

                        >
                        <option value="" disabled selected hidden>Sélectionner le type d'industrie</option>

                          <option
                            v-for="industrie in type_industries"
                            :key="industrie.id"
                            :value="industrie.id"
                          >
                            {{ industrie.name }}
                          </option>
                        </select>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.type_ind" :key="index">{{ err }}<br></span>

                      </div>
                    </div>

                    <!-- Country & state Add  -->
                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label for="country" style="float: left">Pays</label>
                        <select
                        :class="['form-select', {'is-invalid': validationErrorsEdit.country}]"
                          v-model="selectedCountry"
                          @change="handleCountryChange"

                        >
                        <option value="" disabled selected hidden>Sélectionner un pays</option>

                          <option
                            :value="country.id"
                            v-for="country in countries"
                            :key="country.id"
                          >
                            {{ country.name }}
                          </option>
                        </select>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.country" :key="index">{{ err }}<br></span>

                      </div>
                      <div class="col-md-6">
                        <label for="country" style="float: left"
                          >Gouvernorat</label
                        >
                        <select
                        :class="['form-select', {'is-invalid': validationErrorsEdit.city}]"
                          :disabled="selectedCountry == ''"
                          v-model="selectedState"

                        >

                        <option value="" disabled selected hidden>Sélectionner le gouvernorat</option>
                          <option
                            :value="state.id"
                            v-for="state in states"
                            :key="state.id"
                          >
                            {{ state.name }}
                          </option>
                        </select>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.city" :key="index">{{ err }}<br></span>

                      </div>
                    </div>

                    <!-- Form Row        -->
                    <div class="row gx-3 mb-3">

                      <!-- Form Group (location)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="inputLocation"
                          >Numéro du résponsable</label
                        >
                        <input
                        :class="['form-control', {'is-invalid': validationErrorsEdit.N_responsable}]"
                          id="inputLocation"
                          type="text"
                          placeholder="Entrer le numéro du répsponsable"
                          v-model="N_responsable"

                        />
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.N_responsable" :key="index">{{ err }}<br></span>

                      </div>
                    </div>


                    <!-- Form Group (username)-->
                    <div class="mb-3">
                      <label class="small mb-1" for="inputUsername"
                        >Adresse</label
                      >
                      <textarea
                      :class="['form-control', {'is-invalid': validationErrorsEdit.address}]"
                        id="inputUsername"
                        rows="4"
                        placeholder="Entrer votre adresse"
                        v-model="address"

                      ></textarea>
                      <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.address" :key="index">{{ err }}<br></span>

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
    <div v-else-if="formSubmitted && !checkClientDisabled()">
      <div class="alert alert-info" role="alert">
        Votre e-mail est en attente de vérification.
      </div>
    </div>

    <div v-else-if="checkClientDisabled()">
      <div class="alert alert-danger" role="alert">
        Nous vous informons que votre compte a été désactivé temporairement. <br>
         Pour plus d'informations et pour résoudre ce problème, veuillez nous contacter dès que possible.
      </div>
    </div>

    <!-----------------------------------------------show Assignment------------------------------------------>

    <div class="modal fade" id="showAssignment" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-user fa-xl" style="margin-right: 10px"></i>
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
                            value="Il faut changer les cartouches."
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
                      <img v-if="imageShow"
                        :src="'/storage/img/pompes/' + imageShow"
                        class="centered-image img-fluid"
                      />
                      <img v-else
                        :src="'/storage/img/NoImage.png'"
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
import Chart from 'chart.js/auto';
import axios from "axios";


import {
  checkLoginStatus,
  checkLoginAdmin,
  checkClientVerification,
  checkClientDisabled,
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
      validationErrorsEdit:{},
      formSubmitted: false,
      user: {},
      role: null,
      id: "",
      society: "",
      type_ind: "",
      phonecode : "",
      N_responsable: "",
      countries: listCountries,
      selectedCountry: '222',
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

      //Charts
      interventionsDonut:[],
      interventionsClientBarChart:[],
      interventionsMonthlyBarChart:[],

      pieChartData: {
        labels: [],
        datasets: [
          {
            data: [],
          },
        ],
      },

      ClientsBarChartData: {
        labels: [],
        datasets: [
          {
            label:"Nombre d'intérventions",
            data: [],
          },
        ],
      },


      MonthlyBarChartData: {
        labels: [],
        datasets: [
          {
            data: [],
          },
        ],
      },

    };
  },
  mounted() {
    this.fetchClientCount();
    this.fetchInterventionCount();
    this.fetchDiagnosticCount();
    this.fetchNotificationCount();
    //charts
    this.DonutChartData();
    this.ClientsBarChart();
    this.MonthlyChartData();

  },

  created() {
    if (window.Laravel.user) {
      this.user = window.Laravel.user;
      this.role = window.Laravel.user.role;
      this.id = window.Laravel.user.id;
      console.log("user's role is " + this.role);
      console.log("user's id is " + this.id);
      //Client

    //   this.society = window.Laravel.user.society;
    //   this.type_ind = window.Laravel.user.type_ind;
    //   this.N_responsable = window.Laravel.user.N_responsable;
    //   const country = window.Laravel.user.country;

    //   this.selectedState = window.Laravel.user.city;
    //   this.address = window.Laravel.user.address;

    this.$nextTick(() => {
        this.handleCountryChange();
      });
    }
    if (
      this.user.society &&
      this.user.type_ind &&
      this.user.N_responsable &&
      this.user.country &&
      this.user.city &&
      this.user.address
    )
      this.formSubmitted = true;
  },
  methods: {
    isAdmin() {
      return this.role === 2;
    },

    handleCountryChange() {
    this.fireState();
    this.firePhoneCode();
  },

    fireState() {
      this.states = [];
      this.states = listStates.filter(
        (state) => state.country_id === this.selectedCountry
      );
    },

firePhoneCode() {
  const Country = listCountries.find(
    (country) => country.id === this.selectedCountry
  );
  if (Country) {
    this.N_responsable = `(+${Country.phonecode})`;
  }
},


    //Charts
     async DonutChartData() {
      try {
        const response = await axios.get("/api/interventions/DonutChart");
        this.interventionsDonut = response.data.interventions;
        // console.log(this.interventionsDonut);

        this.interventionsDonut.forEach((data) => {
        this.pieChartData.labels.push(data.name);
        this.pieChartData.datasets[0].data.push(data.count);
        });

      const ctx = this.$refs.pieChart.getContext('2d');
      new Chart(ctx, {
        type: 'doughnut',
        data: this.pieChartData,
        options: {
        cutoutPercentage: 50, // Adjust this value to center the doughnut
        responsive: true,
        maintainAspectRatio: false, // To control the aspect ratio
        // Add other chart options as needed
      },
      });

      } catch (error) {
        console.error(error);
      }
    },

    async ClientsBarChart() {
      try {
        const response = await axios.get("/api/interventions/ClientsBarChart");
        this.interventionsClientBarChart = response.data.interventions;
        console.log(this.interventionsClientBarChart);

        this.interventionsClientBarChart.forEach((data) => {
        this.ClientsBarChartData.labels.push(data.society);
        this.ClientsBarChartData.datasets[0].data.push(data.count);
        });

      const ctx = this.$refs.clientsBarChart.getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: this.ClientsBarChartData,
        options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'Sociétés',
        },
      },
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: "Nombre d'interventions",
        },
        ticks: {
          precision: 0,
        },
        borderWidth: 1

      },
    },
},
      });

      } catch (error) {
        console.error(error);
      }
    },

    async MonthlyChartData() {
      try {
        const response = await axios.get("/api/interventions/MonthlyBarChart");
        const interventionsData = response.data.interventions;
        console.log(interventionsData);

        const labels = [
          'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];
        const monthColors = [
          'rgb(255, 99, 132)',
          'rgb(75, 192, 192)',
          'rgb(54, 162, 235)',
          'rgb(255, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(153, 102, 255)',
          'rgb(255, 87, 51)',
          'rgb(101, 203, 75)',
          'rgb(238, 130, 238)',
          'rgb(0, 128, 128)',
          'rgb(255, 0, 0)',
          'rgb(0, 0, 255)'
        ];
        const years = Object.keys(interventionsData);

        const datasets = labels.map((month, index) => {
          const counts = years.map((year) => {
            return interventionsData[year][index + 1] || 0;
          });

          return {
            label: month,
            data: counts,
            backgroundColor: monthColors[index % monthColors.length],
            borderWidth: 1,
          };
        });

        const ctx = this.$refs.MonthlyBarChart.getContext("2d");
        new Chart(ctx, {
          type: "bar",
          data: {
            labels: years,
            datasets: datasets,
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                title: {
                display: true,
                text: "Années",
                },
              },
              y: {
                beginAtZero: true,
                title: {
                display: true,
                text: "Nombre d'interventions",
                },
                ticks: {
                precision: 0,
                },
              },
            },
            plugins: {
              legend: {
                position: "right", // Position the legend on the right side
              },
            },
            layout: {
          padding: {
            top: 30, // Adjust top padding to create space for month labels
          },
        },
          },
        });
      } catch (error) {
        console.error(error);
      }
    },



    async updateClientDetails(user) {
    this.validationErrorsEdit={};
      try {
      await  axios.put(`/api/users/requestVerification/${user.id}`, {
          society: this.society,
          type_ind: this.type_ind,
          N_responsable: this.N_responsable,
          country: this.selectedCountry,
          city: this.selectedState,
          address: this.address,
        });

        this.society = "";
        this.type_ind = "";
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
          title:
            " Demande a été envoyer avec succées!",
        });
        this.$router.push("/dashboard");
      } catch (error) {
        if (error.response.status === 400) {
          // Validation errors, set the validationErrors object
          this.validationErrorsEdit = error.response.data.errors;
          console.log(this.validationErrorsEdit);
        } else {
          // Handle other errors (e.g., server errors)
          this.errorMessage = "Une erreur s'est produite lors de la création du type.";
        }
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
