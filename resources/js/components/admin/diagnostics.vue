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
                v-model="searchDiagnostic"
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
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                        Ajouter un nouveau diagnostic
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
                          :class="['form-select', {'is-invalid': validationErrors.client_id}]"
                          id="client_select"
                          v-model="client"

                        >
                        <option :value="null" hidden selected disabled>Sélectionner un client</option>

                          <option
                            v-for="client in uniqueClients"
                            :key="client.id"
                            :value="client.id"
                          >
                            {{ client.name }}
                          </option>
                        </select>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrors.client_id" :key="index">{{ err }}<br></span>



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
                        :class="['form-select', {'is-invalid': validationErrors.product_id}]"
                          id="product_select"
                          aria-label="Default select example"
                          v-model="product"

                        >
                        <option :value="null" hidden selected disabled>Sélectionner une pompe</option>

                          <option
                            v-for="product in productsForSelectedClient"
                            :key="product.product_id"
                            :value="product.product_id"
                          >
                          {{ product.product[0].id }}-{{ product.product[0].name }}
                          </option>
                        </select>
                        <span class="invalid-feedback" v-for="(err, index) in validationErrors.product_id" :key="index">{{ err }}<br></span>
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
                          :class="['form-control', {'is-invalid': validationErrors.date}]"
                            id="time_day"
                            type="date"
                            v-model="date"

                          />
                          <span class="invalid-feedback" v-for="(err, index) in validationErrors.date" :key="index">{{ err }}<br></span>

                        </div>
                      </div>


      <label class="small mb-1" style="float: left">Informations de Diagnostic</label>
        <br />
<div :class="['container border p-3 mb-3', {'is-invalid': validationErrors.informations}]">

        <div class="border p-3 mb-3" v-for="(information, index) in informations" :key="index">
            <!-- Diagnostic row -->
            <div class="row gx-3 mb-3">
                <div class="col-md-4">
                    <label class="small mb-1" for="def" style="float: left">Défaut</label>
                    <input
                    :class="['form-control', {'is-invalid': validationErrors[`informations.${index}.def`]}]"
                    id="def"
                    v-model="information.def"
                     disabled         />
                    <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`informations.${index}.def`]" :key="ind">{{ err }}<br/></span>

                </div>

                <div class="col-md-4">
                    <label class="small mb-1" for="description" style="float: left">Description</label>
                    <textarea :class="['form-control', {'is-invalid': validationErrors[`informations.${index}.description`]}]" rows="1" placeholder="Entrer la description" v-model="information.description"></textarea>
                    <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`informations.${index}.description`]" :key="ind">{{ err }}<br/></span>

                </div>

                <div class="col-md-3">
                    <label for="image" class="small mb-1" style="float: left">Image</label>
                    <input
                    :class="['form-control', {'is-invalid': validationErrors[`informations.${index}.image`]}]"
                        type="file"
                        ref="informationImages"
                        id="image"
                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`informations.${index}.image`]" :key="ind">{{ err }}<br/></span>


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
        <span class="invalid-feedback" v-for="(err, index) in validationErrors.informations" :key="index">{{ err }}<br></span>


        <!-- Plus button to add more diagnostics -->
        <div class="text-center">
            <button class="btn btn-info" type="button" @click="addDiagnostic">
                <i class="fa-solid fa-plus"></i> Ajouter un diagnostic
            </button>
        </div>

</div>
<span class="invalid-feedback" v-for="(err, index) in validationErrors.informations" :key="index">{{ err }}<br></span>



<label class="small mb-1" style="float: left">Pièces de rechange</label>
<br>
<div :class="['container border p-3 mb-3', {'is-invalid': validationErrors.pieces}]">

        <div
            v-for="(piece, index) in pieces"
            :key="index"
        >
            <!-- Each piece is enclosed in a border -->
            <div class="border p-3 mb-3">
                <div class="row gx-3 mb-3">
                    <div class="col-md-4">
                        <label class="small mb-1" for="designation">Désignation</label>
                        <input
                        :class="['form-control', {'is-invalid': validationErrors[`pieces.${index}.designation`]}]"
                            type="text"
                            id="designation"
                            placeholder="Désignation"
                            v-model="piece.designation"

                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`pieces.${index}.designation`]" :key="ind">{{ err }}<br/></span>

                    </div>

                    <div class="col-md-4">
                        <label class="small mb-1" for="reference">Référence</label>
                        <input
                        :class="['form-control', {'is-invalid': validationErrors[`pieces.${index}.reference`]}]"
                            type="text"
                            id="reference"
                            placeholder="Référence"
                            v-model="piece.reference"

                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`pieces.${index}.reference`]" :key="ind">{{ err }}<br/></span>

                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1" for="quantite">Quantité</label>
                        <input
                        :class="['form-control', {'is-invalid': validationErrors[`pieces.${index}.quantite`]}]"
                            type="number"
                            id="quantite"
                            min="0"
                            placeholder="Quantité"
                            v-model="piece.quantite"

                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrors[`pieces.${index}.quantite`]" :key="ind">{{ err }}<br/></span>
                    </div>
                    <div class="col-md-1 d-flex align-items-start mt-4 ">
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
</div>
<span class="invalid-feedback" v-for="(err, index) in validationErrors.pieces" :key="index">{{ err }}<br></span>


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
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
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
                          :class="['form-select', {'is-invalid': validationErrorsEdit.client_id}]"
                          id="client_select"
                          v-model="client"
                        >
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
                          <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.product_id" :key="index">{{ err }}<br></span>

                        </div>
                      </div>




      <label class="small mb-1" style="float: left">Informations de Diagnostic</label>
        <br />
      <div class="container">
    <form :class="['container border p-3 mb-3', {'is-invalid': validationErrorsEdit.informations}]">
        <div class="border p-3 mb-3" v-for="(information, index) in editInformations" :key="index">
            <!-- Diagnostic row -->
            <div class="row gx-3 mb-3">
                <div class="col-md-4">
                    <label class="small mb-1" for="def" style="float: left">DEF</label>
                    <input
                    :class="['form-control', {'is-invalid': validationErrors[`informations.${index}.def`]}]"
                    id="def"
                    :value="'def' + (index + 1)" disabled                    />
                    <span class="invalid-feedback" v-for="(err,ind) in validationErrorsEdit[`informations.${index}.def`]" :key="ind">{{ err }}<br/></span>

                </div>
                <div class="col-md-4">
                    <label class="small mb-1" for="description" style="float: left">Description</label>
                    <textarea :class="['form-control', {'is-invalid': validationErrorsEdit[`informations.${index}.description`]}]" rows="1" placeholder="Entrer la description" v-model="information.description"></textarea>
                    <span class="invalid-feedback" v-for="(err,ind) in validationErrorsEdit[`informations.${index}.description`]" :key="ind">{{ err }}<br/></span>

                </div>
                <div class="col-md-3">
                    <label for="image" class="small mb-1" style="float: left">Image</label>
                    <input
                    :class="['form-control', {'is-invalid': validationErrorsEdit[`informations.${index}.image`]}]"
                        type="file"
                        ref="informationImagesEdit"
                        id="image"
                        />
                        <span class="invalid-feedback" v-for="(err,ind) in validationErrorsEdit[`informations.${index}.image`]" :key="ind">{{ err }}<br/></span>

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
    <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.pieces" :key="index">{{ err }}<br></span>

</div>


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
                        :class="['form-control', {'is-invalid': validationErrorsEdit[`pieces.${index}.reference`]}]"
                            type="text"
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
                            type="number"
                            id="quantite"
                            min="0"
                            placeholder="Quantité"
                            v-model="piece.quantite"
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

            <div class="modal fade" id="showDiagnostic" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clipboard-list me-2 fa-xl"></i>

                      <h5 class="modal-title mb-0" id="showInterventionLabel">
                        Rapport du Diagnostic
                      </h5>
                    </div>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body" ref="modalBodyRef" style="color: black;">

                    <div class="d-flex justify-content-center">
                <img :src="'../storage/img/GSI-logo-PNG.png'" style="max-width:390px">
                </div>
                <br>
        <table class="bordered-table">
            <thead>
                <tr>
                    <th id="thead" colspan="4" class="text-center text-white">Rapport Technique</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="titles" class="font-weight-bold">Société</td>
                    <td >{{ clientShow }}</td>
                    <td id="titles" class="font-weight-bold">Modèle</td>
                    <td >{{ getProductName(productShow) }}</td>
                </tr>
                <tr>
                    <td id="titles" class="font-weight-bold">Date Diagnostic</td>
                    <td >{{ dateShow }}</td>
                    <td id="titles" class="font-weight-bold">Code GSI</td>
                    <td >{{ productShow }}</td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th id="thead" colspan="4" class="text-center text-white">Diagnostic</th>
                </tr>
            </thead>
            <tbody >
                <tr class="diagnostic-table">
                    <th id="titles" class="font-weight-bold">Défaut</th>
                    <th id="titles" colspan="2" class="font-weight-bold">Description</th>
                    <th id="titles" class="font-weight-bold">Image</th>
                </tr>
                <tr v-for="(information, index) in ShowInformations" :key="index">
                    <td >{{ information.def }}</td>
                    <td colspan="2" >{{ information.description }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        <img :src="'/storage/img/diagnostics/'+information.image" alt="" style="max-width: 50px; max-height: 50px; display: block; margin: 0 auto;">
                    </td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th id="thead" colspan="4" class="text-center text-white">Pièces de Rechange Nécessaires</th>
                </tr>
            </thead>
            <tbody>
                <tr class="pieces-table">
                    <th id="titles" class="font-weight-bold">Désignation</th>
                    <th id="titles" colspan="2" class="font-weight-bold">Référence</th>
                    <th id="titles"  class="font-weight-bold">Quantité</th>
                </tr>
                <tr v-for="(piece, index) in ShowPieces" :key="index">
                    <td >{{ piece.designation }}</td>
                    <td colspan="2" >{{ piece.reference }}</td>
                    <td >{{ piece.quantite }}</td>
                </tr>
            </tbody>
        </table>


                  </div>
                  <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-danger mb-4 mt-1" @click="downloadPdf(showDiagnostic)">Télécharger PDF</button>
            </div>

                </div>
              </div>
            </div>

            <!----------------------------------------------- End show Diagnostic------------------------------------------>
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
import { jsPDF } from "jspdf";
import html2pdf from 'html2pdf.js';

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



//Fetch clients
const uniqueClients = computed(() => {
  const societyMap = new Map(); // Using a Map to store ID-society pairs
  assignments.value.forEach((assignment) => {
    const clientId = assignment.client[0].id;
    const societyName = assignment.client[0].society;
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

const productsForSelectedClient = computed(() => {
  if (client.value !== null) {
    const selectedAssignments = assignments.value.filter(
      (assignment) => assignment.client_id === client.value
    );

    if (selectedAssignments.length > 0) {
      console.log(selectedAssignments);
      return selectedAssignments;
    }
  }

  return null;
});

const displayedDiagnostics = computed(() => {
  const search = searchDiagnostic.value;

  return diagnostics.value.filter((diagnostic) => {
    const productId = diagnostic.product_id.toString().includes(search);
    const societyName = getSocietyName(diagnostic.client_id).toString().toLowerCase();
    const societyNameContainsSearch = societyName.includes(search.toString().toLowerCase());
    const cleanedSearch = (search[0] === 'd' || search[0] === 'D') ? search.substring(1) : search;    const DiagnosticId = diagnostic.id.toString().includes(cleanedSearch);
        return productId || DiagnosticId|| societyNameContainsSearch;
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
        validationErrors : {},
        validationErrorsEdit:{},
        //Create
        client: "",
        product: "",
        date: "",

        pieces: [{ designation: "", reference: "", quantite: "" }],
        informations: [{ def: "def1", description: "", image: "" }],

        //Edit
        diagnosticEdit:{},
        productEdit: "",
        dateEdit: "",
        editInformations: [{ def: "def1", description: "", image: "" }],
        editPieces: [{ designation: "", reference: "", quantite: "" }],

        //Show
        diagnosticShow:{},
        diagnosticId:"",
        clientShow: "",
        productShow: "",
        dateShow: "",
        ShowInformations: [{ def: "", description: "", image: "" }],
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
        const nextDef = this.informations.length + 1;
        this.informations.push({ def: `def${nextDef}`, description: "", image: "" });
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
        const nextDef = this.informations.length + 1;
        this.editInformations.push({ def: `def${nextDef}`, description: "", image: "" });
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



async downloadPdf(diagnostic) {
  const SocietyName=this.getSocietyName(diagnostic.client_id);
  var doc = new jsPDF();
// Source HTMLElement or a string containing HTML.
var elementHTML = this.$refs.modalBodyRef;

doc.html(elementHTML, {
    callback: function(doc) {
        // Save the PDF
        doc.save('rapport-diagnostic '+SocietyName+'_'+diagnostic.product_id+'_'+diagnostic.date+'.pdf');
    },
    x: 15,
    y: 15,
    width: 170, //target width in the PDF document
    windowWidth: 1000 //window width in CSS pixels
});
    },


    async createDiagnostic() {
        this.validationErrors={};
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
        if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage = "Une erreur s'est produite lors de la création du diagnostic.";
        }
        }
      },

      openEditModal(diagnostic) {
        $("#editDiagnostic").modal("show");
        this.validationErrorsEdit={};
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
    const formData = new FormData();
    formData.append("client_id", this.client);
    formData.append("product_id", this.productEdit);
    formData.append("date", this.dateEdit);

    // Append the pieces data
    this.editPieces.forEach((piece, index) => {
      formData.append(`pieces[${index}][designation]`, piece.designation);
      formData.append(`pieces[${index}][reference]`, piece.reference);
      formData.append(`pieces[${index}][quantite]`, piece.quantite);
    });

    // Append the informations data with images
    this.editInformations.forEach((info, index) => {
      formData.append(`informations[${index}][def]`, info.def);
      formData.append(`informations[${index}][description]`, info.description ?? "");

      // Check if an image is present for this information item
      const imageInput = this.$refs.informationImagesEdit[index];
      if (imageInput.files[0]) {
        formData.append(`informations[${index}][image]`, imageInput.files[0]);
        console.log(imageInput.files[0]);
      } else if (info.image) {
        formData.append(`informations[${index}][Currentimage]`, info.image);
        console.log(info.image);
      }
    });

    const response = await axios.post(`/api/diagnostics/update/${diagnostic.id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data', // Set proper content type
      }
    });

    if (response.status === 200) {
      // Diagnostic updated successfully
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
        title: "Diagnostic modifié avec succès!",
      });

      $("#editDiagnostic").modal("hide");
      this.get_all_diagnostics();

      // Clear form fields
      this.client = "";
      this.productEdit = "";
      this.editInformations = [];
      this.editPieces = [];
      this.dateEdit = "";
    } else {
      // Handle unexpected response status
      console.error(`Unexpected status code: ${response.status}`);
    }
  } catch (error) {
    // Handle any unexpected errors
    console.error("An error occurred:", error);
    if (error.response && error.response.status === 400) {
      this.validationErrorsEdit = error.response.data.errors;
      console.log(this.validationErrorsEdit);
    } else {
      this.errorMessage = "Une erreur s'est produite lors de la mise à jour du diagnostic.";
    }
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

      openShowModal(diagnostic) {
        $("#showDiagnostic").modal("show");
        try {
          axios
            .get(`/api/diagnostics/show/${diagnostic.id}`)
            .then((response) => {
              this.showDiagnostic = response.data.diagnostic;
              this.clientShow = this.getSocietyName(
              this.showDiagnostic.client_id
              );
              this.productShow =this.showDiagnostic.product_id;
              this.dateShow = this.showDiagnostic.date;
              this.ShowInformations = this.showDiagnostic.informations;
              this.ShowPieces = this.showDiagnostic.pdrs;
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
  #crudBtn {
    cursor: pointer;
  }
  .bordered-table {
    border-collapse: collapse; /* Collapse table borders */
    width: 100%; /* Set table width to 100% */
    border: 2px solid black; /* Set border color and width for the table */
}
#printable-content img {
          max-width: 100%;
          height: auto;
        }

.bordered-table th,
.bordered-table td {
    border: 2px solid black; /* Set border color and width for table cells */
    padding: 8px; /* Add padding for better spacing */
}

/* Optional: Center-align text in table cells */
.bordered-table th,
.bordered-table td {
    text-align: center;
}
  #thead{
    background-color: #248996;
  }
#titles{
    background-color: #e0f5f8; /* A very, very light shade of blue */
}
  #showDiagnostic .modal-dialog {
            text-align: center;
        }

  #showDiagnostic .modal-body {
      text-align: center;
      color: black;
  }

  </style>
