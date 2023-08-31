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
                type="search"
                class="form-control rounded"
                placeholder="Rechercher"
                aria-label="Search"
                aria-describedby="search-addon"
                v-model="searchType"

              />
            </div>
          </div>
          <div class="col-md-8 text-end">
            <div class="text-end">
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addIntervention"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create intervention------------------------------------------>

            <div class="modal fade" id="addIntervention" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="fa-sharp fa-solid fa-plus fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title col-11" id="addInterventionLabel">
                        Créer une nouvelle intervention
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
                    <div>

                    </div>
                    <form  @submit.prevent="createIntervention()">


                        <div class="row gx-3 mb-3">

                            <!-- Client Dropdown -->
                            <div class="col-md-6">
                            <label class="small mb-1" for="client_select" style="float: left">Clients</label>
                            <select class="form-select" id="client_select" aria-label="Default select example" v-model="client" required>
                                <option value="" selected disabled hidden>Sélectionner un client</option>
                                <option v-for="client in uniqueClients" :key="client.id" :value="client.id">{{ client.name }}</option>
                            </select>
                        </div>



                            <!-- Product Dropdown -->
                            <div class="col-md-6">
                            <label class="small mb-1" for="product_select" style="float: left">Pompes</label>
                                <select class="form-select" id="product_select" aria-label="Default select example" v-model="product" required>
                                    <option value="" selected disabled hidden>Sélectionner un produit</option>
                                    <option v-for="product in productsForSelectedClient" :key="product.product_id" :value="product.product_id">{{ product.product[0].name }}</option>
                                </select>
                            </div>
                        </div>



                        <!-- Nature Dropdown -->
  <div class="row gx-3 mb-3">
    <div class="col-md-6">
      <label class="small mb-1" for="type_prod" style="float: left">Nature</label>
      <select class="form-select" id="type_prod" v-model="name" required>
        <option value="" selected disabled hidden>Sélectionner la nature d'intervention</option>
        <option value="Entretien">Entretien</option>
        <option value="Révision">Révision</option>
        <option value="Réparation">Réparation</option>
      </select>
    </div>

    <!-- Date Input -->
    <div class="col-md-6">
      <label class="small mb-1" for="time_day" style="float: left">Date</label>
      <input class="form-control" id="time_day" type="date" v-model="date" />
    </div>
  </div>



  <!-- Pièces de Rechange -->
  <div class="row gx-3 mb-3" v-for="(piece, index) in pieces" :key="index">
    <div class="col-md-12">
      <label class="small mb-1" style="float: left">Pièces de rechange</label>
      <div class="input-group">
        <input class="form-control" type="text" placeholder="Désignation" v-model="piece.designation" />
        <input class="form-control" type="text" placeholder="Référence" v-model="piece.reference" />
        <input class="form-control" type="text" placeholder="Quantité" v-model="piece.quantite" />
        <button class="btn btn-success" @click="removePiece(index)">-</button>
      </div>
    </div>
  </div>

  <button class="btn btn-primary" @click="addPiece">+</button>


  <!-- Description Textarea -->
  <div class="row gx-3 mb-3">
    <div class="col-md-12">
      <label class="small mb-1" for="description" style="float: left">Description</label>
      <textarea class="form-control" id="description" rows="4" placeholder="Entrer la description" v-model="description"></textarea>
    </div>
  </div>
                              <br>

                        <div class="modal-footer">
                            <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            >
                            Annuler
                            </button>
                            <button
                            type="submit"
                            class="btn btn-primary"
                            >
                             Ajouter
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Create type_industrie------------------------------------------>

            <!-----------------------------------------------Edit type_industrie------------------------------------------>

            <div class="modal fade" id="editTypeIndustry" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title mb-0" id="editTypeIndustryLabel">
                        Modifier le type d'industrie
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
                    <form @submit.prevent="updateType(typeEdit)" >

                        <div class="mb-3">
                                  <label
                                    class="small mb-1"
                                    for="name"
                                    style="float: left"
                                    >Nom</label
                                  >
                                  <input
                                    class="form-control"
                                    id="name"
                                    rows="4"
                                    placeholder="Entrer le nom d'industrie"
                                    v-model="name"
                                    required
                                  >
                        </div>

                        <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-secondary"
                          data-bs-dismiss="modal"
                        >
                          Annuler
                        </button>
                        <button
                          type="submit"
                          class="btn btn-primary"
                        >
                          Modifier</button>
                      </div>
                    </form>


                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Edit User------------------------------------------>

          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-solid fa-industry me-2"></i>
          <h5 class="mb-0">Interventions</h5>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nature</th>
              <th scope="col">Société</th>
              <th scope="col">Pompe</th>
              <th scope="col">CODE GSI</th>
              <th scope="col">Date d'intervention</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody v-if="interventions.length > 0">
            <tr v-for="intervention in displayedInterventions" :key="intervention.id">
              <th scope="row">{{ intervention.id }}</th>
              <td>{{ intervention.name }}</td>
              <td>{{ intervention.name }}</td>
              <td>{{ intervention.name }}</td>
              <td>{{ intervention.name }}</td>
              <td>{{ intervention.name }}</td>
              <td>{{ intervention.name }}</td>
              <td>{{ intervention.name }}</td>
              <td>
                <a
                  id="crudBtn"
                  @click="openEditModal(type_ind)"
                  class="me-4 text-warning"
                >
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a id="crudBtn" @click="deleteType(type_ind.id)" class="text-danger">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <p>Pas de types d'industrie</p>
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
          <a v-else class="page-link shadow" @click="changePage(page)">{{ page }}</a>
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

  let interventions = ref([]);
  let assignments= ref([]);

  let searchType = ref([]);

  const currentPage = ref(1);
  const itemsPerPage = ref(5); // Set the default number of items per page


  onMounted(async () => {
    get_all_interventions();
    get_all_assignments();
  });


  const get_all_interventions = async () => {
    try {
      let response = await axios.get("/api/get_all_interventions");
      console.log(response.data); // Log the response data
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

  //Fetch clients
  const uniqueClients = computed(() => {
  const societyMap = new Map(); // Using a Map to store ID-society pairs
  assignments.value.forEach(assignment => {
    const clientId = assignment.client[0].id;
    const societyName = assignment.client[0].society; // Assuming 'society' property holds the society name
    societyMap.set(clientId, societyName); // Store ID-society pairs in the Map
  });

  // Create an array of objects containing society ID and name
  const societies = Array.from(societyMap, ([id, name]) => ({ id, name }));

  return societies;
});


//Fetch Products by clients

let client = ref(null);
let product = ref(null);

const productsForSelectedClient = computed(() => {
  if (client.value !== null) {
    const selectedAssignments = assignments.value.filter(
      assignment => assignment.client_id === client.value
    );

    if (selectedAssignments.length > 0) {
        console.log(selectedAssignments);
      return selectedAssignments; // Assuming you want the product of the first selected assignment
    }
  }

  return null; // Return a default value if no products are found
});




  const search = async () => {
    let response = await axios.get("/api/interventions/search_type?s=" + searchType.value);
    console.log("response", response);
    interventions.value = response.data.interventions;
    interventions.value = response.data.interventions;
  };


  //Page numbers
  const displayedInterventions = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return interventions.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(interventions.value.length / itemsPerPage.value)
  );

  const changePage = (page) => {
    currentPage.value = page;
  };
  </script>


    <script>
  export default {
      name: "interventions",
    //check auth
    beforeRouteEnter(to, from, next) {
      if (checkLoginAdmin()) {
        next();
      } else {
        next("/login");
      }
    },
    data() {
      return {
        //Create
        name: "",
        client: "",
        product: "",
        description: "",
        designation: "",
        reference: "",
        quantite: "",

        pieces: [
            { designation: '', reference: '', quantite: '' }
        ]

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
            pages.push('...');
            pages.push(this.totalPages);
          } else if (this.currentPage >= this.totalPages - 2) {
            pages.push(1);
            pages.push('...');
            for (let i = this.totalPages - 4; i <= this.totalPages; i++) {
              pages.push(i);
            }
          } else {
            pages.push(1);
            pages.push('...');
            for (let i = this.currentPage - 1; i <= this.currentPage + 1; i++) {
              pages.push(i);
            }
            pages.push('...');
            pages.push(this.totalPages);
          }
        }

        return pages;
      },
    },
    methods: {

    addPiece() {
      this.pieces.push({ designation: '', reference: '', quantite: '' });
    },
    removePiece(index) {
      this.pieces.splice(index, 1);
    },

      changePage(page) {
        this.$emit("page-change", page);
      },



      async createIntervention() {
        console.log(this.client);
        console.log(this.name);
        console.log(this.product);
        console.log(this.description);
        console.log(this.date);
        console.log(this.pieces);
        try {
            const formData = {
                name: this.name,
                client_id: this.client,
                product_id: this.product,
                description: this.description,
                date: this.date,
                pieces: this.pieces,
                };
          const response = await axios.post('/api/interventions/create',formData);

        console.log(response.data.message);
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
            title: "Intervention ajoutée avec succés !",
          });

          this.$router.push("/interventions");
          this.name = "";
          this.client_id = "";
          this.product_id = "";
          this.description = "";
          this.date = "";
          this.pieces = [];
        } catch (error) {
            console.error('Error creating intervention:', error);
        }
      },


      openEditModal(type_ind) {
        $("#editTypeIndustry").modal("show");
        this.name = type_ind.name;
        this.typeEdit=type_ind;
          },

      updateType(type_ind) {
        try {
          axios.put(`/api/types_industrie/update/${type_ind.id}`, {
            name: this.name,
          });



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
            title: "Element modifié avec succés!",
          });

          $("#editTypeIndustry").modal("hide");
          $(".modal-backdrop").hide();

          this.get_all_types();
          this.typeEdit = {};
        } catch (error) {
          console.log(error);
        }
      },

      deleteType(type_id) {
        Swal.fire({
          title: "Êtes-vous sûr(e) ?",
          text: "Vous ne pourrez pas revenir en arrière !",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Oui, supprimez-le !",
          cancelButtonText: "Annuler",
        }).then((result) => {
          if (result.isConfirmed) {
              axios
                .post("/api/types_industrie/delete/" + type_id)
                .then((response) => {
                  this.get_all_types();
                  console.log(response);
                  Swal.fire("Supprimé!", "L'élement a été supprimé!", "success");
                })
                .catch((errors) => {
                  console.log(errors);
                  Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Il y a eu un problème!",
                    });
                });
          }
        });
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
