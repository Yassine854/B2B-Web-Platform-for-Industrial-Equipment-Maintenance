<template>
  <layout ref="table">
    <div
      class="shadow p-3"
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
              <select :class="['form-select', {'is-invalid': validationErrors.client_id}]" id="client_select" v-model="client" >
                <option :value="null" selected hidden disabled>Sélectionner un client</option>
                <option v-for="client in uniqueClients" :key="client.id" :value="client.id">{{ client.name }}</option>
              </select>
              <span class="invalid-feedback" v-for="(err, index) in validationErrors.client_id" :key="index">{{ err }}<br></span>

            </div>
            <div class="col-md-6">
              <label class="small mb-1" for="product_select" style="float: left;">Pompes</label>
              <select :class="['form-select', {'is-invalid': validationErrors.product_id}]" id="product_select" v-model="product" >
                <option :value="null" disabled selected hidden>Sélectionner une pompe</option>
                <option v-for="product in productsForSelectedClient" :key="product.product_id" :value="product.product_id">{{ product.product[0].id }}-{{ product.product[0].name }}</option>
              </select>
              <span class="invalid-feedback" v-for="(err, index) in validationErrors.product_id" :key="index">{{ err }}<br></span>

            </div>
          </div>

          <!-- Nature and Date Inputs -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="type_prod" style="float: left;">Nature</label>
              <select :class="['form-select', {'is-invalid': validationErrors.name}]" id="type_prod" v-model="name" >
                <option value="" selected disabled hidden>Sélectionner la nature d'intervention</option>
                <option value="Entretien">Entretien</option>
                <option value="Révision">Révision</option>
                <option value="Réparation">Réparation</option>
              </select>
              <span class="invalid-feedback" v-for="(err, index) in validationErrors.name" :key="index">{{ err }}<br></span>

            </div>
            <div class="col-md-6">
              <label class="small mb-1" for="date" style="float: left;">Date</label>
              <input :class="['form-control', {'is-invalid': validationErrors.date}]" id="date" type="date" v-model="date"  />
              <span class="invalid-feedback" v-for="(err, index) in validationErrors.date" :key="index">{{ err }}<br></span>

            </div>
          </div>

          <!-- Diagnostic Selection -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="diagnostic_select" style="float: left;">Diagnostic</label>
              <select :class="['form-select', {'is-invalid': validationErrors.diagnostic_id}]" id="diagnostic_select" v-model="diagnostic" @change="loadPieces(diagnostic)">
                <option value="" selected disabled hidden>Sélectionner un diagnostic</option>
                <option v-for="diagnostic in diagnosticsForSelectedClientProduct" :key="diagnostic.id" :value="diagnostic.id">D{{ diagnostic.id }}</option>
              </select>
              <span class="invalid-feedback" v-for="(err, index) in validationErrors.diagnostic_id" :key="index">{{ err }}<br></span>

            </div>
          </div>

          <!-- Pièces de Rechange -->
          <label class="small mb-1" style="float: left;">Pièces de rechange</label>
          <br />
          <div :class="['container border p-3 mb-3', {'is-invalid': validationErrors.pieces}]">
            <!-- Pieces Input Section (Repeatable) -->
            <div v-for="(piece, index) in pieces" :key="index" class="border p-3 mb-3">
              <div class="row gx-3 mb-3">
                <div class="col-md-4">
                  <label class="small mb-1" for="designation" style="float: left;">Désignation</label>
                  <input :class="['form-control', {'is-invalid': validationErrors[`pieces.${index}.designation`]}]" type="text" id="designation" placeholder="Désignation" v-model="piece.designation"  />
                  <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`pieces.${index}.designation`]" :key="ind">{{ err }}<br/></span>

                </div>
                <div class="col-md-4">
                  <label class="small mb-1" for="reference" style="float: left;">Référence</label>
                  <input :class="['form-control', {'is-invalid': validationErrors[`pieces.${index}.reference`]}]" type="text" id="reference" placeholder="Référence" v-model="piece.reference"  />
                  <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`pieces.${index}.reference`]" :key="ind">{{ err }}<br/></span>

                </div>
                <div class="col-md-3">
                  <label class="small mb-1" for="quantite" style="float: left;">Quantité</label>
                  <input :class="['form-control', {'is-invalid': validationErrors[`pieces.${index}.quantite`]}]" type="text" id="quantite" placeholder="Quantité" v-model="piece.quantite"  />
                  <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`pieces.${index}.quantite`]" :key="ind">{{ err }}<br/></span>

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
          <span class="invalid-feedback" v-for="(err, index) in validationErrors.pieces" :key="index">{{ err }}<br></span>

          <!-- Description Textarea -->
          <div class="row mb-3">
            <div class="col-md-12">
              <label class="small mb-1" for="description" style="float: left;">Description</label>
              <textarea class="form-control" id="description" rows="4" placeholder="Entrer la description" v-model="description" ></textarea>
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
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
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
                        :class="['form-select', {'is-invalid': validationErrorsEdit.client_id}]"
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
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.client_id" :key="index">{{ err }}<br></span>

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
                        :class="['form-select', {'is-invalid': validationErrorsEdit.product_id}]"
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
                          {{ product.product[0].id }}-{{ product.product[0].name }}
                          </option>
                        </select>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.product_id" :key="index">{{ err }}<br></span>

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
                        :class="['form-select', {'is-invalid': validationErrorsEdit.name}]"
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
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.name" :key="index">{{ err }}<br></span>

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
                        :class="['form-control', {'is-invalid': validationErrorsEdit.date}]"
                          id="time_day"
                          type="date"
                          v-model="dateEdit"
                        />
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.date" :key="index">{{ err }}<br></span>

                      </div>
                    </div>

            <div class="row mb-3">
            <div class="col-md-6">
              <label class="small mb-1" for="diagnostic_select" style="float: left;">Diagnostic</label>
              <select :class="['form-select', {'is-invalid': validationErrorsEdit.diagnostic_id}]" id="diagnostic_select" v-model="diagnosticEdit" @change="loadPiecesEdit(diagnosticEdit)">
                <option :value="null" selected disabled hidden>Sélectionner un diagnostic</option>

                <option value=""></option>

                <option v-for="diagnostic in diagnosticsForSelectedClientProduct" :key="diagnostic.id" :value="diagnostic.id" >D{{ diagnostic.id }}</option>
              </select>
              <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.diagnostic_id" :key="index">{{ err }}<br></span>

            </div>
          </div>

                    <!-- Pièces de Rechange -->
                    <label class="small mb-1" style="float: left">Pièces de rechange</label>
<br>
<div class="container">
    <form :class="['container border p-3 mb-3', {'is-invalid': validationErrorsEdit.pieces}]">
        <div
            v-for="(piece, index) in editPieces"
            :key="index"
        >
            <!-- Each piece is enclosed in a border -->
            <div class="border p-3 mb-3">
                <div class="row gx-3 mb-3">
                    <div class="col-md-4">
                        <label class="small mb-1" for="designation">Désignation</label>
                        <input
                        :class="['form-control', {'is-invalid': validationErrorsEdit[`pieces.${index}.designation`]}]"
                            type="text"
                            id="designation"
                            placeholder="Désignation"
                            v-model="piece.designation"

                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrorsEdit[`pieces.${index}.designation`]" :key="ind">{{ err }}<br/></span>

                    </div>
                    <div class="col-md-4">
                        <label class="small mb-1" for="reference">Référence</label>
                        <input
                        :class="['form-control', {'is-invalid': validationErrorsEdit[`pieces.${index}.reference`]}]" type="text"
                            id="reference"
                            placeholder="Référence"
                            v-model="piece.reference"

                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrorsEdit[`pieces.${index}.reference`]" :key="ind">{{ err }}<br/></span>

                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1" for="quantite">Quantité</label>
                        <input
                        :class="['form-control', {'is-invalid': validationErrorsEdit[`pieces.${index}.quantite`]}]"
                            type="text"
                            id="quantite"
                            placeholder="Quantité"
                            v-model="piece.quantite"
                            required
                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrorsEdit[`pieces.${index}.quantite`]" :key="ind">{{ err }}<br/></span>

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
    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.pieces" :key="index">{{ err }}<br></span>

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
                        :class="['form-control', {'is-invalid': validationErrorsEdit.description}]"
                          id="description"
                          rows="4"
                          placeholder="Entrer la description"
                          v-model="descriptionEdit"
                        ></textarea>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.description" :key="index">{{ err }}<br></span>

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
                    <i class="fa-brands fa-servicestack fa-xl me-2"></i>
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
                    <div class="modal-body" ref="modalBodyRef" style="color: black;">

<div class="d-flex justify-content-center">
<img :src="'../storage/img/GSI-logo-PNG.png'" style="max-width:390px">
</div>
<br>
<table class="bordered-table">
    <thead>
        <tr>
            <th id="thead" colspan="4" class="text-center text-white">Intervention</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td id="titles" class="font-weight-bold">Société</td>
            <td>{{ clientShow }}</td>
            <td id="titles" class="font-weight-bold">Modèle</td>
            <td>{{ getProductName(productShow) }}</td>
        </tr>
        <tr>
            <td id="titles" class="font-weight-bold">Date Intervention</td>
            <td>{{ dateShow }}</td>
            <td id="titles" class="font-weight-bold">Code GSI</td>
            <td>{{ productShow }}</td>
        </tr>
        <tr>
            <td id="titles" class="font-weight-bold">Nature d'intervention</td>
            <td colspan="3">{{ nameShow }}</td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th id="thead" colspan="4" class="text-center text-white">Pièces de Rechange Nécessaires</th>
        </tr>
    </thead>
    <tbody class="pieces-table">
        <tr>
            <th id="titles" class="font-weight-bold">Désignation</th>
            <th id="titles" colspan="2" class="font-weight-bold">Référence</th>
            <th id="titles" class="font-weight-bold">Quantité</th>
        </tr>
        <tr v-for="(piece, index) in ShowPieces" :key="index">
            <td>{{ piece.designation }}</td>
            <td colspan="2">{{ piece.reference }}</td>
            <td>{{ piece.quantite }}</td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th id="thead" colspan="4" class="text-center text-white">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4">{{ descriptionShow }}</td>
        </tr>
    </tbody>
</table>



</div>
<div class="d-flex justify-content-center align-items-center">
<button class="btn btn-danger mb-4 mt-1" @click="downloadPdf(showIntervention)">Télécharger PDF</button>
</div>

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
import { jsPDF } from "jspdf";
window.Swal = Swal;
let interventions = ref([]);
let assignments = ref([]);
let diagnostics = ref(null);

let searchIntervention = ref([]);

const currentPage = ref(1);
const itemsPerPage = ref(10);

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
    if(assignment.client[0].disabled==false)
    societyMap.set(clientId, societyName); // Store ID-society pairs in the Map
  });

  // Create an array of objects containing society ID and name
  const societies = Array.from(societyMap, ([id, name]) => ({ id, name }));

  return societies;
});

//Fetch Products by clients

let client = ref(null);
let product = ref(null);
let productEdit = ref(null);

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

  return null;
});

// const diagnosticsForSelectedClientProduct = computed(() => {
//   if (client.value !== null && (product.value !== null || productEdit.value !== null ) ){
//     const selectedDiagnostics = diagnostics.value.filter(
//       (diagnostic) =>
//       diagnostic.client_id === client.value && (diagnostic.product_id==product.value || diagnostic.product_id==productEdit.value)
//     );

//     if (selectedDiagnostics.length > 0) {
//         this.pieces.value.push({ designation: "h", reference: "h", quantite: "h" });
//       console.log(selectedDiagnostics)
//       return selectedDiagnostics;
//     }
//   }

//   return null;
// });



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
    validationErrors : {},
    validationErrorsEdit:{},
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
      diagnosticPieces:[],
      editdiagnosticPieces:[],
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

    diagnosticsForSelectedClientProduct() {
      if (this.client !== null && (this.product !== null || this.productEdit !== null)) {
        const selectedDiagnostics = this.diagnostics.filter(
          (diagnostic) =>
            diagnostic.client_id === this.client &&
            (diagnostic.product_id === this.product || diagnostic.product_id === this.productEdit)
        );

        if (selectedDiagnostics.length > 0) {
          // Assuming pieces is a ref or reactive property in your component's data
          console.log(this.pieces);
          console.log(selectedDiagnostics);
          return selectedDiagnostics;
        }
      }

      return null;
    },


  },
  methods: {
    loadPieces(diagnostic_id) {
  try {
    axios.get(`/api/diagnostics/show/${diagnostic_id}`)
      .then((response) => {
        const diagnosticInfo = response.data.diagnostic;
        console.log("hey");
        console.log(diagnosticInfo.pdrs);

        if (diagnosticInfo) {
        this.diagnosticPieces=diagnosticInfo.pdrs;
         this.pieces=[];
          diagnosticInfo.pdrs.forEach((pdr) => {
            this.pieces.push({
              designation: pdr.designation,
              reference: pdr.reference,
              quantite: pdr.quantite
            });
          });
        }
      })
      .catch((error) => {
        console.error("Error loading diagnostic information:", error);
      });
  } catch (error) {
    console.error("Error loading pieces:", error);
  }
},

loadPiecesEdit(diagnostic_id) {
  try {
    axios.get(`/api/diagnostics/show/${diagnostic_id}`)
      .then((response) => {
        const diagnosticInfo = response.data.diagnostic;
        console.log(diagnosticInfo);

        if (diagnosticInfo) {
         this.editPieces=[];
         this.editdiagnosticPieces=diagnosticInfo.pdrs;
          diagnosticInfo.pdrs.forEach((pdr) => {
            this.editPieces.push({
              designation: pdr.designation,
              reference: pdr.reference,
              quantite: pdr.quantite
            });
          });
        }
      })
      .catch((error) => {
        console.error("Error loading diagnostic information:", error);
      });
  } catch (error) {
    console.error("Error loading pieces:", error);
  }
},
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


async downloadPdf(intervention) {
  const SocietyName=this.getSocietyName(intervention.client_id);
  var doc = new jsPDF();
// Source HTMLElement or a string containing HTML.
var elementHTML = this.$refs.modalBodyRef;

doc.html(elementHTML, {
    callback: function(doc) {
        // Save the PDF
        doc.save('intervention '+SocietyName+'_'+intervention.product_id+'_'+intervention.date+'.pdf');
    },
    x: 15,
    y: 15,
    width: 170, //target width in the PDF document
    windowWidth: 1000 //window width in CSS pixels
});
    },

    changePage(page) {
      this.$emit("page-change", page);
    },

    async createIntervention() {
        this.validationErrors={};
        // console.log("all:",this.pieces);

        // console.log("diag:",this.diagnosticPieces);

        const difference = this.pieces.filter(item1 =>
            !this.diagnosticPieces.some(item2 =>
                item1.designation === item2.designation &&
                item1.reference === item2.reference &&
                item1.quantite === item2.quantite
            )
            );

// console.log("diff is :",difference);
      try {
            const assignmentResponse = await axios.get(`/api/assignments/${this.client}/${this.product}`);
            const assignmentData = assignmentResponse.data.assignment;


        const formData = {
          name: this.name,
          client_id: this.client,
          product_id: this.product,
          assignment_id:assignmentData.id,
          diagnostic_id:this.diagnostic,
          description: this.description,
          date: this.date,
          diagnosticPieces: this.diagnosticPieces,
          interventionPieces: difference,
        };
        const response = await axios.post(
          "/api/interventions/create",
          formData
        );
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
        if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création d'intervention.";
        }
      }
    },

    openEditModal(intervention) {
      $("#editIntervention").modal("show");
      this.validationErrorsEdit={};
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
      console.log(intervention);

      console.log(this.productEdit);
      console.log(this.client);

    },

    async updateIntervention(intervention) {
        const difference = this.editPieces.filter(item1 =>
            !this.editdiagnosticPieces.some(item2 =>
                item1.designation === item2.designation &&
                item1.reference === item2.reference &&
                item1.quantite === item2.quantite
            )
            );

      try {
        const assignmentResponse = await axios.get(`/api/assignments/${this.client}/${this.productEdit}`);
        const assignmentData = assignmentResponse.data.assignment;

        await axios.put(`/api/interventions/update/${intervention.id}`, {
          name: this.nameEdit,
          client_id: this.client,
          product_id: this.productEdit,
          diagnostic_id:this.diagnosticEdit,
          assignment_id:assignmentData.id,
          description: this.descriptionEdit,
          date: this.dateEdit,
          diagnosticPieces: this.editdiagnosticPieces,
          interventionPieces: difference,
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
        if (error.response.status === 400) {
          this.validationErrorsEdit = error.response.data.errors;
          console.log(this.validationErrorsEdit);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création d'intervention.";
        }
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
            this.productShow=response.data.intervention.product_id;
            this.clientShow = this.getSocietyName(
              this.showIntervention.client_id
            );
            this.dateShow = this.showIntervention.date;
            this.ShowPieces = this.showIntervention.pdrs;
            this.descriptionShow = this.showIntervention.description;

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
