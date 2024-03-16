<template>
  <layout ref="table">
    <div
      class=" shadow p-3"
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
              v-model="searchSociety"
            />
          </div>
        </div>
        <div class="col-md-8 text-end">
          <div class="text-end">
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#addProduct"
            >
              <i class="fa-solid fa-plus"></i>
            </button>
          </div>

          <!-----------------------------------------------Create assignment------------------------------------------>

          <div class="modal fade" id="addProduct" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-plus fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
                      Affecter une pompe au client
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
                  <form @submit.prevent="createAssignment()">
                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="type_prod"
                          style="float: left"
                          >Clients</label
                        >
                        <select
                          :class="[
                            'form-select',
                            { 'is-invalid': validationErrors.client_id },
                          ]"
                          id="type_prod"
                          aria-label="Default select example"
                          v-model="client"
                        >
                          <option value="" selected disabled hidden>
                            Sélectionner un client
                          </option>
                          <option
                            v-for="client in clients"
                            :key="client.id"
                            :value="client.id"
                          >
                            {{ client.society }}
                          </option>
                        </select>
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.client_id"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="type_prod"
                          style="float: left"
                          >Pompe</label
                        >
                        <select
                          :class="[
                            'form-select',
                            { 'is-invalid': validationErrors.product_id },
                          ]"
                          id="type_prod"
                          aria-label="Default select example"
                          v-model="product"
                        >
                          <option value="" selected disabled hidden>
                            Sélectionner une pompe
                          </option>
                          <option
                            v-for="product in products"
                            :key="product.id"
                            :value="product.id"
                          >
                            {{ product.id }}-{{ product.name }}
                          </option>
                        </select>
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.product_id"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>
                    </div>
                    <div class="row gx-3 mb-3">
                      <div class="col-md-12">
                        <label class="small mb-1" for="date" style="float: left"
                          >Date de changement</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.date },
                          ]"
                          id="date"
                          rows="4"
                          type="date"
                          v-model="date"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.date"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>
                    </div>

                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="Année"
                          style="float: left"
                          >Changement d'huile</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.c_huile },
                          ]"
                          id="Année"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement d'huile"
                          v-model="c_huile"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.c_huile"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="time_day"
                          style="float: left"
                          >Changement des cartouches de filtres</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.c_filtre },
                          ]"
                          id="time_day"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement de filtre"
                          v-model="c_filtre"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.c_filtre"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>
                    </div>

                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="ch_palette"
                          style="float: left"
                          >Changement des palettes</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.ch_palette },
                          ]"
                          id="ch_palette"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement des palettes"
                          v-model="ch_palette"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.ch_palette"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="insp_palette"
                          style="float: left"
                          >Inspection des Palettes</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.insp_palette },
                          ]"
                          id="insp_palette"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps d'inspection des palettes"
                          v-model="insp_palette"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.insp_palette"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>
                    </div>

                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="Année"
                          style="float: left"
                          >Changement des déshuileurs</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.c_dehuil },
                          ]"
                          id="Année"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement des déshuileurs"
                          v-model="c_dehuil"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.c_dehuil"
                          :key="index"
                          >{{ err }}<br
                        /></span>
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="inputOrgName"
                          style="float: left"
                          >Entretien</label
                        >
                        <input
                          :class="[
                            'form-control',
                            { 'is-invalid': validationErrors.entretien },
                          ]"
                          id="inputOrgName"
                          type="text"
                          placeholder="Entrer le temps d'entretien"
                          v-model="entretien"
                        />
                        <span
                          class="invalid-feedback"
                          v-for="(err, index) in validationErrors.entretien"
                          :key="index"
                          >{{ err }}<br
                        /></span>
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
                        Ajouter
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!----------------------------------------------- End Create assignment------------------------------------------>
        </div>
      </div>
      <br />

      <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
          <i class="fa-solid fa-users me-2"></i>
          <h5 class="mb-0">Parc Clients</h5>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Société</th>
                <th scope="col">État</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody v-if="displayedSocietiesSlice.length > 0">
              <tr
                v-for="(assignment, index) in displayedSocietiesSlice"
                :key="index"
                id="crudBtn"
                @click="ShowAssignments(assignment.client[0].id)"
              >
                <td v-if="assignment.client">
                  {{ assignment.client[0].society }}
                </td>
                <td>
                  <div v-if="assignment.client[0].disabled == false">
                    <i class="fa-solid fa-circle text-success"></i>
                    <p>Actif</p>
                  </div>
                  <div v-if="assignment.client[0].disabled == true">
                    <i class="fa-solid fa-circle text-danger"></i>
                    <p>Désactivé</p>
                  </div>
                </td>
                <th>
                  <i class="fa-solid fa-chevron-right fa-lg text-dark"></i>
                </th>
              </tr>
            </tbody>

            <tbody v-else>
              <p>Pas de parcs</p>
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
import layout from "../layouts/layout";
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

let clients = ref([]);
let products = ref([]);
let searchSociety = ref([]);
let assignmentsArray = ref([]);

const currentPage = ref(1);
const itemsPerPage = ref(10); // Set the default number of items per page

const get_all_assignments = async () => {
  try {
    const response = await axios.get("/api/get_all_assignments");
    console.log(response.data);
    assignmentsArray.value = response.data.assignments;
  } catch (error) {
    console.log("sry");
    console.error(error);
  }
};

const get_all_clients = async () => {
  try {
    let response = await axios.get("/api/get_all_clients");
    console.log(response.data);
    clients.value = response.data.clients;
  } catch (error) {
    console.error(error);
  }
};

const get_all_products = async () => {
  try {
    let response = await axios.get("/api/get_all_products");
    console.log(response.data); // Log the response data
    products.value = response.data.products;
  } catch (error) {
    console.error(error);
  }
};

const displayedSocieties = computed(() => {
  const searchSocietyLower =
    typeof searchSociety.value === "string"
      ? searchSociety.value.toLowerCase()
      : "";

  return assignmentsArray.value.filter((assignment) => {
    const SocietyName = (assignment.client[0]?.society || "").toLowerCase();
    // Perform case-insensitive search for both name and ID
    return SocietyName.includes(searchSocietyLower);
  });
});

const displayedSocietiesSlice = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return displayedSocieties.value.slice(startIndex, endIndex);
});

const totalPages = computed(() =>
  Math.ceil(displayedSocieties.value.length / itemsPerPage.value)
);

const changePage = (page) => {
  currentPage.value = page;
};

onMounted(async () => {
  get_all_assignments();
  get_all_products();
  get_all_clients();
});
</script>

    <script>
export default {
  name: "parc_clients",
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
      validationErrors: {},
      validationErrorsEdit: {},
      client: "",
      product: "",
      date: "",
      c_huile: "",
      c_filtre: "",
      c_dehuil: "",
      entretien: "",
      ch_palette: "",
      insp_palette: "",
      assignmentsArray: [],
      Index: 0,
      currentPage: 1,
      itemsPerPage: 10,
    };
  },
  mounted() {},

  props: {
    type_industries: Array,
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
    uploadImage(e) {
      this.image = e.target.files[0];
    },

    uploadImageEdit(e) {
      this.imageEdit = e.target.files[0];
    },

    async createAssignment() {
      console.log(this.date);
      this.validationErrors = {};
      try {
        let form = new FormData();
        form.append("client_id", this.client);
        form.append("product_id", this.product);
        form.append("date", this.date);
        form.append("c_huile", this.c_huile);
        form.append("c_filtre", this.c_filtre);
        form.append("c_dehuil", this.c_dehuil);
        form.append("entretien", this.entretien);
        form.append("ch_palette", this.ch_palette);
        form.append("insp_palette", this.insp_palette);
        await axios.post(`/api/assignments/create`, form);
        console.log(form);
        this.client = "";
        this.product = "";
        this.date = "";
        this.c_huile = "";
        this.c_filtre = "";
        this.c_dehuil = "";
        this.entretien = "";
        this.ch_palette = "";
        this.insp_palette = "";

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
          title: "Attribution ajouté avec succés !",
        });
        $("#addProduct").modal("hide");
        this.$router.push("/parc_clients");
        window.location.reload();
      } catch (error) {
        if (error.response.status === 400) {
          this.validationErrors = error.response.data.errors;
          console.log(this.validationErrors);
        } else {
          this.errorMessage =
            "Une erreur s'est produite lors de la création du produit.";
        }
      }
    },

    ShowAssignments(client_id) {
      this.$router.push({
        name: "parc",
        params: { id: client_id },
        props: true,
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

.image {
  width: 200px;
  height: 200px;
  overflow: hidden;
  background-color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 1em;
  position: relative;
}

.centered-image {
  max-width: 100%;
  max-height: 100%;
  display: block;
  margin: auto;
}

td img {
  display: block;
  max-width: 100px;
  max-height: 100px;
}
</style>
