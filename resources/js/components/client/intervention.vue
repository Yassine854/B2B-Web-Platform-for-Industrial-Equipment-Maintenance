<template>
    <layout ref="table">
      <div
        class="container shadow p-3"
        style="background-color: white; position: relative"
      >
        <div class="row">
          <div class="col-md-4">
            <div class="input-group rounded">
              <input
                type="text"
                class="form-control rounded"
                placeholder="Rechercher"
                aria-label="Search"
                aria-describedby="search-addon"
                v-model="searchIntervention"
              />
            </div>
          </div>
          <div class="col-md-8 text-end">

            <!-----------------------------------------------show intervention------------------------------------------>

            <div class="modal fade" id="showIntervention" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                      <i
                        class="fa-solid fa-pen fa-xl"
                        style="margin-right: 10px"
                      ></i>
                      <h5 class="modal-title mb-0" id="showInterventionLabel">
                        Détails de l'intervention
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
                      <div class="row gx-4">
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="small" for="name" style="float: left"
                              >Société</label
                            >
                            <input
                              class="form-control"
                              id="name"
                              type="text"
                              v-model="clientShow"
                              disabled
                            />
                          </div>
                          <div class="mb-3">
                            <label class="small" for="pompe" style="float: left"
                              >Pompe</label
                            >
                            <input
                              class="form-control"
                              id="pompe"
                              type="text"
                              v-model="productShow"
                              disabled
                            />
                          </div>
                          <div class="mb-3">
                            <label class="small" for="nature" style="float: left"
                              >Nature</label
                            >
                            <input
                              class="form-control"
                              id="nature"
                              type="text"
                              v-model="nameShow"
                              disabled
                            />
                          </div>
                          <div class="mb-3">
                            <label class="small" for="nature" style="float: left"
                              >Diagnostic</label
                            >
                            <input
                              class="form-control"
                              id="nature"
                              type="text"
                              :value="'D' + diagnosticShow"
                              disabled
                              />

                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="small" for="date" style="float: left"
                              >Date de l'intervention</label
                            >
                            <input
                              class="form-control"
                              id="date"
                              type="text"
                              v-model="dateShow"
                              disabled
                            />
                          </div>
                          <div class="mb-3">
                            <label
                              class="small"
                              for="Description"
                              style="float: left"
                              >Description</label
                            >
                            <textarea
                              class="form-control"
                              rows="8"
                              id="Description"
                              v-model="descriptionShow"
                              disabled
                            ></textarea>
                          </div>
                        </div>
                        <div class="col-md-12 mt-3">
                          <label
                            class="small"
                            for="PiecesDeRechange"
                            style="float: left"
                            >Pièces de rechange</label
                          >
                          <div
                            v-for="(piece, index) in ShowPieces"
                            :key="index"
                            class="mb-3"
                          >
                            <div class="input-group">
                              <span class="input-group-text">Désignation</span>
                              <input
                                class="form-control"
                                type="text"
                                v-model="piece.designation"
                                disabled
                              />
                              <span class="input-group-text">Référence</span>
                              <input
                                class="form-control"
                                type="text"
                                v-model="piece.reference"
                                disabled
                              />
                              <span class="input-group-text">Quantité</span>
                              <input
                                class="form-control"
                                type="text"
                                v-model="piece.quantite"
                                disabled
                              />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 mt-3">
                          <div
                            class="d-flex align-items-center justify-content-center"
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

            <!----------------------------------------------- End show Intervention------------------------------------------>
          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-brands fa-servicestack me-2"></i>
            <h5 class="mb-0">Interventions</h5>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Pompe</th>
                  <th scope="col">CODE GSI</th>
                  <th scope="col">Nature</th>
                  <th scope="col">Date d'intervention</th>
                  <th scope="col">Afficher</th>
                </tr>
              </thead>
              <tbody v-if="interventions.length > 0">
                <tr
                  v-for="intervention in displayedInterventionsSlice"
                  :key="intervention.id"
                >
                  <th scope="row">#INT{{ intervention.id }}</th>
                  <td>{{ getProductName(intervention.product_id) }}</td>
                  <th>#{{ intervention.product_id }}</th>
                  <td>{{ intervention.name }}</td>
                  <td>{{ intervention.date }}</td>

                  <td style="text-align: center;">
                    <a
                        id="crudBtn"
                        class="me-4 text-info"
                        style="display: inline-block;"
                        @click="openShowModal(intervention)"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    </td>

                </tr>
              </tbody>
              <tbody v-else>
                <p>Pas d'interventions</p>
              </tbody>
            </table>
          </div>
        </div>

        <nav aria-label="User pagination" v-if="totalPages > 1" class="pb-1">
          <ul class="pagination justify-content-end">
            <li class="page-item" v-if="currentPage !== 1">
              <a
                id="crudBtn"
                class="page-link shadow"
                @click="changePage(currentPage - 1)"
              >
                Précédent
              </a>
            </li>
            <li
              class="page-item"
              :class="{ active: page === currentPage }"
              v-for="(page, index) in displayedPages"
              :key="index"
              style="cursor: pointer"
            >
              <a v-if="page === '...'" class="page-link shadow">...</a>
              <a v-else class="page-link shadow" @click="changePage(page)">{{
                page
              }}</a>
            </li>
            <li class="page-item" v-if="currentPage !== totalPages">
              <a
                class="page-link shadow"
                @click="changePage(currentPage + 1)"
                id="crudBtn"
              >
                Suivant
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </layout>
  </template>


      <script setup>
  import layout from "../layouts/layout.vue";
  import {
    checkLoginStatus,
    checkLoginAdmin,
    checkLoginClient,
    checkClientVerification,
    checkClientNotVerified,
  } from "../../auth";
  import { onMounted, ref, computed } from "vue";
  import { useRouter } from "vue-router";
  import Swal from "sweetalert2";
  import axios from "axios";
  window.Swal = Swal;

  const userID = ref(null);
  let interventions = ref([]);
  let assignments = ref([]);
  let diagnostics = ref([]);

  let searchIntervention = ref([]);

  const currentPage = ref(1);
  const itemsPerPage = ref(10);

  onMounted(async () => {

    if (window.Laravel.user) {
      userID.value = window.Laravel.user.id;
    }

    get_all_interventions();
    get_all_assignments();
    get_all_diagnostics();
  });

  const get_all_interventions = async () => {
    try {
    let response = await axios.get(`/api/getClientInterventions/${userID.value}`);
      console.log(response.data);
      interventions.value = response.data.interventions;
    } catch (error) {
      console.error(error);
    }
  };

  const get_all_assignments = async () => {
    try {
      let response = await axios.get("/api/interventions/get_all_assignments");
      console.log(response.data); // Log the response data
      assignments.value = response.data.assignments;
    } catch (error) {
      console.error(error);
    }
  };

  const get_all_diagnostics = async () => {
    try {
      let response = await axios.get("/api/get_all_diagnostics");
      console.log(response.data);
      diagnostics.value = response.data.diagnostics;
    } catch (error) {
      console.error(error);
    }
  };

  const getSocietyName = (clientId) => {
    const assignment = assignments.value.find(
      (assignment) => assignment.client_id === clientId
    );
    return assignment ? assignment.client[0].society : "";
  };

  const getProductName = (productId) => {
    const assignment = assignments.value.find(
      (assignment) => assignment.product_id === productId
    );
    return assignment ? assignment.product[0].name : "";
  };

  const getProductImage = (productId) => {
    const assignment = assignments.value.find(
      (assignment) => assignment.product_id === productId
    );
    if (assignment && assignment.product.length > 0) {
      const product = assignment.product[0];
      // Assuming you have an "image" property in the product object
      return product.image || ""; // Replace '' with a default image URL if needed
    } else {
      return ""; // Handle the case when no assignment is found for the given productId
    }
  };


  //Fetch Products by clients

  const displayedInterventions = computed(() => {
    const search = searchIntervention.value; // Convert search term to lowercase for case-insensitive search

    return interventions.value.filter((intervention) => {
      const productId=intervention.product_id.toString().includes(search);
      const societyName = getSocietyName(intervention.client_id).toString().toLowerCase();
      const societyNameContainsSearch = societyName.includes(search.toString().toLowerCase());

      const cleanedSearch = (search[0] === 'i' || search[0] === 'I') && (search[1] === 'n' || search[1] === 'N' && search[2] === 't' || search[2] === 'T') ? search.substring(3) : search;
      const interventionId = intervention.id.toString().includes(cleanedSearch);
      return productId ||interventionId || societyNameContainsSearch
    });
  });

  //Page numbers
  const displayedInterventionsSlice = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return displayedInterventions.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(displayedInterventions.value.length / itemsPerPage.value)
  );

  const changePage = (page) => {
    currentPage.value = page;
  };
  </script>


      <script>
  export default {
    name: "client_interventions",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkClientVerification()) {
        next();
      } else {
        next("/login");
      }
    },
    data() {
      return {
        //Show
        nameShow: "",
        clientShow: "",
        productShow: "",
        diagnosticShow:"",
        descriptionShow: "",
        dateShow: "",

        ShowPieces: [{ designation: "", reference: "", quantite: "" }],
      };
    },

    props: {
      itemsPerPage: Number,
      currentPage: Number,
      totalPages: Number,
    },
    computed: {
      displayedPages() {
        const pages = [];
        const maxDisplayedPages = Math.min(5, this.totalPages);

        if (this.totalPages <= 5) {
          for (let i = 1; i <= maxDisplayedPages; i++) {
            pages.push(i);
          }
        } else {
          if (this.currentPage <= 3) {
            for (let i = 1; i <= 5; i++) {
              pages.push(i);
            }
            pages.push("...");
            pages.push(this.totalPages);
          } else if (this.currentPage >= this.totalPages - 2) {
            pages.push(1);
            pages.push("...");
            for (let i = this.totalPages - 4; i <= this.totalPages; i++) {
              pages.push(i);
            }
          } else {
            pages.push(1);
            pages.push("...");
            for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) {
              pages.push(i);
            }
            pages.push("...");
            pages.push(this.totalPages);
          }
        }

        return pages;
      },
    },
    methods: {
      openShowModal(intervention) {
        $("#showIntervention").modal("show");
        try {
          axios
            .get(`/api/interventions/show/${intervention.id}`)
            .then((response) => {
              this.showIntervention = response.data.intervention;
              this.nameShow = this.showIntervention.name;
              this.clientShow = this.getSocietyName(
                this.showIntervention.client_id
              );
              this.productShow = this.getProductName(
                this.showIntervention.product_id
              );
              this.diagnosticShow = this.showIntervention.diagnostic_id;
              this.dateShow = this.showIntervention.date;
              this.ShowPieces = this.showIntervention.pdrs;
              this.descriptionShow = this.showIntervention.description;
              this.imageShow = this.getProductImage(
                this.showIntervention.product_id
              );
            })
            .catch((error) => {
              console.error(error);
            });
        } catch (error) {
          console.error(error);
        }
      },
    },
  };
  </script>

      <style>
  /* Add your custom styles here if needed */
  #crudBtn {
    cursor: pointer;
  }
  </style>
