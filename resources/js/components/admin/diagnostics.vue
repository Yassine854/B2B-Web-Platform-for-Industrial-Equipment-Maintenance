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
                v-model="searchSiagnostic"
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

        <!-----------------------------------------------Create Diagnostic------------------------------------------>

            <div class="modal fade" id="addIntervention" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div
                      class="d-flex align-items-center justify-content-center mb-3"
                    >
                      <i
                        class="fa-sharp fa-solid fa-plus fa-xl"
                        style="margin-right: 10px"
                      ></i>
                      <h5 class="modal-title col-11" id="addInterventionLabel">
                        Créer un nouvel diagnostic
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
                    <form @submit.prevent="createDiagnostic()">
                      <div class="row gx-3 mb-3">
                        <!-- Client Dropdown -->
                        <div class="col-md-6">
                          <label
                            class="small mb-1"
                            for="client_select"
                            style="float: left"
                            >Clients</label
                          >
                          <select
                          class="form-select"
                          id="client_select"
                          v-model="client"
                          required
                        >
                        <option value="" disabled>Sélectionner un client</option>

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
                          v-model="product"
                          required
                        >
                        <option value="" disabled>Sélectionner une pompe</option>

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
                            v-model="date"
                            required
                          />
                        </div>
                      </div>


      <label class="small mb-1" style="float: left">Informations de Diagnostic</label>
        <br />
      <div class="container">
    <form class="border p-3 mb-3">
        <div class="border p-3 mb-3" v-for="(information, index) in informations" :key="index">
            <!-- Diagnostic row -->
            <div class="row gx-3 mb-3 align-items-center">
                <div class="col-md-4">
                    <label class="small mb-1" for="def" style="float: left">DEF</label>
                    <select class="form-select" v-model="information.def" required>
                        <option v-for="n in 20" :key="n" :value="`def${n}`">def{{ n }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small mb-1" for="description" style="float: left">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Entrer la description" v-model="information.description" required></textarea>
                </div>
                <div class="col-md-3">
                    <label for="image" class="small mb-1" style="float: left">Image</label>
                    <input
                        class="form-control"
                        type="file"
                        ref="informationImages"
                        id="image"
                        />
                </div>
                <div class="col-md-1 d-flex align-items-start mt-4">
                    <button
                        class="btn btn-danger"
                        type="button"
                        @click="removeDiagnostic(index)"
                    >
                        -
                    </button>
                </div>
            </div>
        </div>

        <!-- Plus button to add more diagnostics -->
        <div class="text-center">
            <button class="btn btn-info" type="button" @click="addDiagnostic">
                <i class="fa-solid fa-plus"></i> Ajouter un diagnostic
            </button>
        </div>
    </form>
</div>


<label class="small mb-1" style="float: left">Pièces de rechange</label>
<br>
<div class="container">
    <form class="border p-3 mb-3">
        <div
            v-for="(piece, index) in pieces"
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
                        />
                    </div>
                    <div class="col-md-1 d-flex align-items-start mt-4 mb-md-0">
                        <button
                            class="btn btn-danger"
                            type="button"
                            @click="removePiece(index)"
                        >
                            -
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plus button to add more pieces -->
        <div class="text-center">
            <button class="btn btn-info" type="button" @click="addPiece">
                <i class="fa-solid fa-plus"></i> Ajouter une pièce
            </button>
        </div>
    </form>
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
        Ajouter
        </button>
    </div>
    </form>
    </div>

</div>
</div>
</div>

            <!----------------------------------------------- End Create Diagnostic------------------------------------------>

            <!-----------------------------------------------Edit Diagnostic------------------------------------------>

            <div class="modal fade" id="editDiagnostic" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div
                      class="d-flex align-items-center justify-content-center mb-3"
                    >
                      <i
                        class="fa-sharp fa-solid fa-plus fa-xl"
                        style="margin-right: 10px"
                      ></i>
                      <h5 class="modal-title col-11" id="EditDiagnosticLabel">
                        Modifier le diagnostic
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
                    <form @submit.prevent="updateDiagnostic(diagnosticEdit)">
                      <div class="row gx-3 mb-3">
                        <!-- Client Dropdown -->
                        <div class="col-md-6">
                          <label
                            class="small mb-1"
                            for="client_select"
                            style="float: left"
                            >Clients</label
                          >
                          <select
                          class="form-select"
                          id="client_select"
                          v-model="client"
                          required
                        >
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
                          required
                        >

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
                            required
                          />
                        </div>
                      </div>




      <label class="small mb-1" style="float: left">Informations de Diagnostic</label>
        <br />
      <div class="container">
    <form class="border p-3 mb-3">
        <div class="border p-3 mb-3" v-for="(information, index) in editInformations" :key="index">
            <!-- Diagnostic row -->
            <div class="row gx-3 mb-3 align-items-center">
                <div class="col-md-4">
                    <label class="small mb-1" for="def" style="float: left">DEF</label>
                    <select class="form-select" v-model="information.def" required>
                        <option v-for="n in 20" :key="n" :value="`def${n}`">def{{ n }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="small mb-1" for="description" style="float: left">Description</label>
                    <textarea class="form-control" rows="1" placeholder="Entrer la description" v-model="information.description" required></textarea>
                </div>
                <div class="col-md-3">
                    <label for="image" class="small mb-1" style="float: left">Image</label>
                    <input
                        class="form-control"
                        type="file"
                        ref="informationImages"
                        id="image"
                        />
                </div>
                <div class="col-md-1 d-flex align-items-start mt-4">
                    <button
                        class="btn btn-danger"
                        type="button"
                        @click="removeDiagnosticEdit(index)"
                    >
                        -
                    </button>
                </div>
            </div>
        </div>

        <!-- Plus button to add more diagnostics -->
        <div class="text-center">
            <button class="btn btn-info" type="button" @click="addDiagnosticEdit">
                <i class="fa-solid fa-plus"></i> Ajouter un diagnostic
            </button>
        </div>
    </form>
</div>


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
            <!----------------------------------------------- End edit Diagnostic------------------------------------------>

            <!-----------------------------------------------show Diagnostic------------------------------------------>

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
                              rows="4"
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
            <h5 class="mb-0">Diagnostics</h5>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">CODE GSI</th>
                  <th scope="col">Pompe</th>
                  <th scope="col">Société</th>
                  <th scope="col">Date de diagnostic</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody v-if="diagnostics.length > 0">
                <tr
                  v-for="diagnostic in displayedDiagnosticsSlice"
                  :key="diagnostic.id"
                >
                  <th scope="row">#D{{ diagnostic.id }}</th>
                  <th>#{{ diagnostic.product_id }}</th>
                  <td>{{ getProductName(diagnostic.product_id)  }}</td>
                  <td>{{ getSocietyName(diagnostic.client_id)  }}</td>
                  <td>{{ diagnostic.date }}</td>
                  <td>
                    <a
                      id="crudBtn"
                      class="me-4 text-info"
                      @click="openShowModal(diagnostic)"
                    >
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <a
                      id="crudBtn"
                      @click="openEditModal(diagnostic)"
                      class="me-4 text-warning"
                    >
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <a
                      id="crudBtn"
                      @click="deleteDiagnostic(diagnostic.id)"
                      class="text-danger"
                    >
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <p>Pas de diagnostics</p>
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
let diagnostics = ref([]);
let assignments = ref([]);

let searchDiagnostic = ref([]);

const currentPage = ref(1);
const itemsPerPage = ref(10); // Set the default number of items per page

onMounted(async () => {
  get_all_diagnostics();
  get_all_assignments();
});

const get_all_diagnostics = async () => {
  try {
    let response = await axios.get("/api/get_all_diagnostics");
    console.log(response.data);
    diagnostics.value = response.data.diagnostics;
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

const displayedDiagnostics = computed(() => {
  const search = searchDiagnostic.value; // Convert search term to lowercase for case-insensitive search

  return diagnostics.value.filter((diagnostic) => {
    // Convert product_id to a string and check if it contains the search term
    return diagnostic.product_id.toString().includes(search);
  });
});

//Page numbers
const displayedDiagnosticsSlice = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return displayedDiagnostics.value.slice(startIndex, endIndex);
});

const totalPages = computed(() =>
  Math.ceil(displayedDiagnostics.value.length / itemsPerPage.value)
);

const changePage = (page) => {
  currentPage.value = page;
};
</script>

      <script>
  export default {
    name: "diagnostics",
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
        client: "",
        product: "",
        date: "",

        pieces: [{ designation: "", reference: "", quantite: "" }],
        informations: [{ def: "", description: "", image: "" }],

        //Edit
        diagnosticEdit:{},
        productEdit: "",
        dateEdit: "",
        editInformations: [{ def: "", description: "", image: "" }],
        editPieces: [{ designation: "", reference: "", quantite: "" }],

        //Show
        nameShow: "",
        clientShow: "",
        productShow: "",
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

      addDiagnostic() {
        this.informations.push({ def: "", description: "", image: "" });
      },
      removeDiagnostic(index) {
        this.informations.splice(index, 1);
      },

      addPieceEdit() {
        this.editPieces.push({ designation: "", reference: "", quantite: "" });
      },
      removePieceEdit(index) {
        this.editPieces.splice(index, 1);
      },

      addDiagnosticEdit() {
        this.editInformations.push({ def: "", description: "", image: "" });
      },
      removeDiagnosticEdit(index) {
        this.editInformations.splice(index, 1);
      },
      changePage(page) {
        this.$emit("page-change", page);
      },
      uploadImage(e){
        this.image=e.target.files[0];
      },

      async createDiagnostic() {
        console.log(this.client);
        console.log(this.product);
        console.log(this.date);
        console.log(this.informations);
        console.log(this.pieces);
        try {
    const formData = new FormData();
    formData.append("client_id", this.client);
    formData.append("product_id", this.product);
    formData.append("date", this.date);

    // Append the pieces data
    this.pieces.forEach((piece, index) => {
      formData.append(`pieces[${index}][designation]`, piece.designation);
      formData.append(`pieces[${index}][reference]`, piece.reference);
      formData.append(`pieces[${index}][quantite]`, piece.quantite);
    });

    // Append the informations data with images
    this.informations.forEach((info, index) => {
      formData.append(`informations[${index}][def]`, info.def);
      formData.append(`informations[${index}][description]`, info.description);

      // Check if an image is present for this information item
      const imageInput = this.$refs.informationImages[index];
      if (imageInput.files[0]) {
        formData.append(`informations[${index}][image]`, imageInput.files[0]);
      }
    });
          const response = await axios.post(
            "/api/diagnostics/create",
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
            title: "Diagnostic ajoutée avec succés !",
          });
          this.client = [];
          this.product = [];
          this.informations = [];
          this.pieces = [];
          this.date = "";
          $("#addIntervention").modal("hide");
          this.get_all_diagnostics();
        } catch (error) {
          console.error("Error creating diagnostic:", error);
        }
      },

      openEditModal(diagnostic) {
        $("#editDiagnostic").modal("show");
        this.diagnosticEdit = diagnostic;
        this.client = diagnostic.client_id;
        this.productEdit = diagnostic.product_id;
        this.dateEdit = diagnostic.date;
        this.editInformations = diagnostic.informations.map((information) => ({
          def: information.def,
          description: information.description,
          image: information.image,
        }));
        this.editPieces = diagnostic.pdrs.map((piece) => ({
          designation: piece.designation,
          reference: piece.reference,
          quantite: piece.quantite,
        }));
      },

      async updateDiagnostic(diagnostic) {
        try {
          await axios.put(`/api/diagnostics/update/${diagnostic.id}`, {
            client_id: this.client,
            product_id: this.productEdit,
            date: this.dateEdit,
            informations: this.editInformations,
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
            title: "Diagnostic modifié avec succés!",
          });

          $("#editDiagnostic").modal("hide");
          this.get_all_diagnostics();

          this.client = [];
          this.productEdit = [];
          this.editInformations = [];
          this.editPieces = [];
          this.date = "";
        } catch (error) {
          console.log(error);
        }
      },

      deleteDiagnostic(diagnostic_id) {
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
              .post("/api/diagnostics/delete/" + diagnostic_id)
              .then((response) => {
                this.get_all_diagnostics();
                console.log(response);
                Swal.fire(
                  "Supprimé!",
                  "Diagnostic a été supprimé!",
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
