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
        <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Ajouter une nouvelle intervention
                    </h5>
                    </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form @submit.prevent="createIntervention()">
          <!-- Client and Product Selection -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="client_select" style="float: left;">Clients</label>
              <select class="form-select" id="client_select" v-model="client" required>
                <option value="" disabled>Sélectionner un client</option>
                <option v-for="client in uniqueClients" :key="client.id" :value="client.id">{{ client.name }}</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="small mb-1" for="product_select" style="float: left;">Pompes</label>
              <select class="form-select" id="product_select" v-model="product" required>
                <option :value="null" disabled selected hidden>Sélectionner une pompe</option>
                <option v-for="product in productsForSelectedClient" :key="product.product_id" :value="product.product_id">{{ product.product[0].name }}</option>
              </select>
            </div>
          </div>

          <!-- Nature and Date Inputs -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="type_prod" style="float: left;">Nature</label>
              <select class="form-select" id="type_prod" v-model="name" required>
                <option value="" selected disabled hidden>Sélectionner la nature d'intervention</option>
                <option value="Entretien">Entretien</option>
                <option value="Révision">Révision</option>
                <option value="Réparation">Réparation</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="small mb-1" for="time_day" style="float: left;">Date</label>
              <input class="form-control" id="time_day" type="date" v-model="date" required />
            </div>
          </div>

          <!-- Diagnostic Selection -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="diagnostic_select" style="float: left;">Diagnostic</label>
              <select class="form-select" id="diagnostic_select" v-model="diagnostic">
                <option value="" disabled>Sélectionner un diagnostic</option>
                <option v-for="diagnostic in diagnostics" :key="diagnostic.id" :value="diagnostic.id">D{{ diagnostic.id }}</option>
              </select>
            </div>
          </div>

          <!-- Pièces de Rechange -->
          <label class="small mb-1" style="float: left;">Pièces de rechange</label>
          <br />
          <div class="container border p-3 mb-3">
            <!-- Pieces Input Section (Repeatable) -->
            <div v-for="(piece, index) in pieces" :key="index" class="border p-3 mb-3">
              <div class="row gx-3 mb-3 align-items-center">
                <div class="col-md-4">
                  <label class="small mb-1" for="designation" style="float: left;">Désignation</label>
                  <input class="form-control" type="text" id="designation" placeholder="Désignation" v-model="piece.designation" required />
                </div>
                <div class="col-md-4">
                  <label class="small mb-1" for="reference" style="float: left;">Référence</label>
                  <input class="form-control" type="text" id="reference" placeholder="Référence" v-model="piece.reference" required />
                </div>
                <div class="col-md-3">
                  <label class="small mb-1" for="quantite" style="float: left;">Quantité</label>
                  <input class="form-control" type="number" id="quantite" min="0" placeholder="Quantité" v-model="piece.quantite" required />
                </div>
                <div class="col-md-1 d-flex align-items-start mt-4 mb-md-0">
                  <button class="btn btn-danger" type="button" @click="removePiece(index)">-</button>
                </div>
              </div>
            </div>

            <!-- Plus Button to Add More Pieces -->
            <div class="text-center">
              <button class="btn btn-info" type="button" @click="addPiece"><i class="fa-solid fa-plus"></i> Ajouter une pièce</button>
            </div>
          </div>

          <!-- Description Textarea -->
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="small mb-1" for="description" style="float: left;">Description</label>
              <textarea class="form-control" id="description" rows="4" placeholder="Entrer la description" v-model="description" required></textarea>
            </div>
          </div>
          <br />

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



          <!----------------------------------------------- End Create Intervention------------------------------------------>

          <!-----------------------------------------------Edit intervention------------------------------------------>

          <div class="modal fade" id="editIntervention" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <div
                    class="d-flex align-items-center justify-content-center mb-3"
                  >
                    <i
                      class="fa-sharp fa-solid fa-plus fa-xl"
                      style="margin-right: 10px"
                    ></i>
                    <h5 class="modal-title col-11" id="editInterventionLabel">
                      Modifier l'intervention
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
                  <div></div>
                  <form
                    method="PUT"
                    @submit.prevent="updateIntervention(interventionEdit)"
                  >
                    <div class="row gx-3 mb-3">
                      <!-- Client Dropdown -->
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="client"
                          style="float: left"
                          >Clients</label
                        >
                        <select
                          class="form-select"
                          id="client" v-model="client"
                        >
                          <option value="" selected disabled hidden>
                            Sélectionner un client
                          </option>
                          <option
                            v-for="client in uniqueClients"
                            :key="client.id"
                            :value="client.id"
                          >
                            {{ client.name }}
                          </option>
                        </select>
                      </div>

                      <!-- Product Dropdown -->
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="product_select"
                          style="float: left"
                          >Pompes</label
                        >
                        <select
                          class="form-select"
                          id="product_select"
                          aria-label="Default select example"
                          v-model="productEdit"
                        >
                          <option value="" selected disabled hidden>
                            Sélectionner un produit
                          </option>
                          <option
                            v-for="product in productsForSelectedClient"
                            :key="product.product_id"
                            :value="product.product_id"
                          >
                            {{ product.product[0].name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Nature Dropdown -->
                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="type_prod"
                          style="float: left"
                          >Nature</label
                        >
                        <select
                          class="form-select"
                          id="type_prod"
                          v-model="nameEdit"
                        >
                          <option value="" selected disabled hidden>
                            Sélectionner la nature d'intervention
                          </option>
                          <option value="Entretien">Entretien</option>
                          <option value="Révision">Révision</option>
                          <option value="Réparation">Réparation</option>
                        </select>
                      </div>

                      <!-- Date Input -->
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="time_day"
                          style="float: left"
                          >Date</label
                        >
                        <input
                          class="form-control"
                          id="time_day"
                          type="date"
                          v-model="dateEdit"
                        />
                      </div>
                    </div>

            <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="diagnostic_select" style="float: left;">Diagnostic</label>
              <select class="form-select" id="diagnostic_select" v-model="diagnosticEdit">
                <option v-for="diagnostic in diagnostics" :key="diagnostic.id" :value="diagnostic.id">D{{ diagnostic.id }}</option>
              </select>
            </div>
          </div>

                    <!-- Pièces de Rechange -->
                    <label class="small mb-1" style="float: left">Pièces de rechange</label>
<br>
<div class="container">
    <form class="border p-3 mb-3">
        <div
            v-for="(piece, index) in editPieces"
            :key="index"
        >
            <!-- Each piece is enclosed in a border -->
            <div class="border p-3 mb-3">
                <div class="row gx-3 mb-3 align-items-center">
                    <div class="col-md-4">
                        <label class="small mb-1" for="designation">Désignation</label>
                        <input
                            class="form-control"
                            type="text"
                            id="designation"
                            placeholder="Désignation"
                            v-model="piece.designation"
                            required
                        />
                    </div>
                    <div class="col-md-4">
                        <label class="small mb-1" for="reference">Référence</label>
                        <input
                            class="form-control"
                            type="text"
                            id="reference"
                            placeholder="Référence"
                            v-model="piece.reference"
                            required
                        />
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1" for="quantite">Quantité</label>
                        <input
                            class="form-control"
                            type="number"
                            id="quantite"
                            min="0"
                            placeholder="Quantité"
                            v-model="piece.quantite"
                            required
                        />
                    </div>
                    <div class="col-md-1 d-flex align-items-start mt-4 mb-md-0">
                        <button
                            class="btn btn-danger"
                            type="button"
                            @click="removePieceEdit(index)"
                        >
                            -
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plus button to add more pieces -->
        <div class="text-center">
            <button class="btn btn-info" type="button" @click="addPieceEdit">
                <i class="fa-solid fa-plus"></i> Ajouter une pièce
            </button>
        </div>
    </form>
</div>

                    <!-- Description Textarea -->
                    <div class="row gx-3 mb-3">
                      <div class="col-md-12">
                        <label
                          class="small mb-1"
                          for="description"
                          style="float: left"
                          >Description</label
                        >
                        <textarea
                          class="form-control"
                          id="description"
                          rows="4"
                          placeholder="Entrer la description"
                          v-model="descriptionEdit"
                        ></textarea>
                      </div>
                    </div>
                    <br />

                    <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                      >
                        Annuler
                      </button>
                      <button type="submit" class="btn btn-primary">
                        Modifier
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!----------------------------------------------- End edit intervention------------------------------------------>

          <!-----------------------------------------------show intervention------------------------------------------>

          <div class="modal fade" id="showIntervention" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-brands fa-servicestack me-2"></i>
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
                        <div class="mb-3" v-if="diagnosticShow">
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
                <th scope="col">Société</th>
                <th scope="col">Pompe</th>
                <th scope="col">CODE GSI</th>
                <th scope="col">Nature</th>
                <th scope="col">Date d'intervention</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody v-if="interventions.length > 0">
              <tr
                v-for="intervention in displayedInterventionsSlice"
                :key="intervention.id"
              >
                <th scope="row">#INT{{ intervention.id }}</th>
                <td>{{ getSocietyName(intervention.client_id) }}</td>
                <td>{{ getProductName(intervention.product_id) }}</td>
                <th>#{{ intervention.product_id }}</th>
                <td>{{ intervention.name }}</td>
                <td>{{ intervention.date }}</td>

                <td>
                  <a
                    id="crudBtn"
                    class="me-4 text-info"
                    @click="openShowModal(intervention)"
                  >
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a
                    id="crudBtn"
                    @click="openEditModal(intervention)"
                    class="me-4 text-warning"
                  >
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a
                    id="crudBtn"
                    @click="deleteIntervention(intervention.id)"
                    class="text-danger"
                  >
                    <i class="fa-solid fa-trash"></i>
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
let interventions = ref([]);
let assignments = ref([]);
let diagnostics = ref([]);

let searchIntervention = ref([]);

const currentPage = ref(1);
const itemsPerPage = ref(10); // Set the default number of items per page

onMounted(async () => {
  get_all_interventions();
  get_all_assignments();
  get_all_diagnostics();
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

//Fetch clients
const uniqueClients = computed(() => {
  const societyMap = new Map(); // Using a Map to store ID-society pairs
  assignments.value.forEach((assignment) => {
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
      (assignment) => assignment.client_id === client.value
    );

    if (selectedAssignments.length > 0) {
      console.log(selectedAssignments);
      return selectedAssignments; // Assuming you want the product of the first selected assignment
    }
  }

  return null; // Return a default value if no products are found
});

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
      diagnostic:"",
      description: "",
      designation: "",
      reference: "",
      quantite: "",
      date: "",

      pieces: [{ designation: "", reference: "", quantite: "" }],

      //Edit
      nameEdit: "",
      clientEdit: "",
      productEdit: "",
      descriptionEdit: "",
      diagnosticEdit:"",
      dateEdit: "",

      editPieces: [{ designation: "", reference: "", quantite: "" }],

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
    addPiece() {
      this.pieces.push({ designation: "", reference: "", quantite: "" });
    },
    removePiece(index) {
      this.pieces.splice(index, 1);
    },

    addPieceEdit() {
      this.editPieces.push({ designation: "", reference: "", quantite: "" });
    },
    removePieceEdit(index) {
      this.editPieces.splice(index, 1);
    },

    changePage(page) {
      this.$emit("page-change", page);
    },

    async createIntervention() {
      try {
        const formData = {
          name: this.name,
          client_id: this.client,
          product_id: this.product,
          diagnostic_id:this.diagnostic,
          description: this.description,
          date: this.date,
          pieces: this.pieces,
        };
        const response = await axios.post(
          "/api/interventions/create",
          formData
        );

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
        this.name = "";
        this.client = [];
        this.product = [];
        this.description = "";
        this.date = "";
        this.pieces = [];
        $("#addIntervention").modal("hide");
        this.get_all_interventions();
      } catch (error) {
        console.error("Error creating intervention:", error);
      }
    },

    openEditModal(intervention) {
      $("#editIntervention").modal("show");
      this.interventionEdit = intervention;
      this.nameEdit = intervention.name;
      this.client = intervention.client_id;
      this.productEdit = intervention.product_id;
      this.diagnosticEdit = intervention.diagnostic_id;
      this.descriptionEdit = intervention.description;
      this.dateEdit = intervention.date;
      this.editPieces = intervention.pdrs.map((piece) => ({
        designation: piece.designation,
        reference: piece.reference,
        quantite: piece.quantite,
      }));
      console.log("intervention:");
      console.log(this.editPieces);
    },

    async updateIntervention(intervention) {
      try {

        await axios.put(`/api/interventions/update/${intervention.id}`, {
          name: this.nameEdit,
          client_id: this.client,
          product_id: this.productEdit,
          diagnostic_id:this.diagnosticEdit,
          description: this.descriptionEdit,
          date: this.dateEdit,
          pieces: this.editPieces,
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
          title: "Intervention modifié avec succés!",
        });

        $("#editIntervention").modal("hide");

        this.get_all_interventions();
        this.interventionEdit = {};
        this.nameEdit = "";
        this.client = "";
        this.productEdit = "";
        this.descriptionEdit = "";
        this.dateEdit = "";
        this.editPieces = [];
      } catch (error) {
        console.log(error);
      }
    },

    deleteIntervention(intervention_id) {
      Swal.fire({
        title: "Êtes-vous sûr(e) ?",
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Oui, supprimez-la !",
        cancelButtonText: "Annuler",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("/api/interventions/delete/" + intervention_id)
            .then((response) => {
              this.get_all_interventions();
              console.log(response);
              Swal.fire(
                "Supprimé!",
                "L'intervention a été supprimé!",
                "success"
              );
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
