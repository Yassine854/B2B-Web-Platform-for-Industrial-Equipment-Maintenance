<template>
  <layout ref="table">
    <div
      class="container shadow p-3"
      style="background-color: white; position: relative"
    >
    <div class="row">
        <div class="d-flex justify-content-between">
            <a
  :href="$router.resolve({ name: 'parc_clients' }).href"
  class="nav-link"
>
<i class="fa-regular fa-circle-left fa-2xl"></i>
</a>
      <button
        type="button"
        class="btn btn-primary text-end"
        data-bs-toggle="modal"
        data-bs-target="#addAssignment"
      >
        <i class="fa-solid fa-plus"></i>
      </button>
    </div>

  <div class="col-md-4">

    <div class="input-group rounded">
      <input
        type="search"
        class="form-control rounded"
        placeholder="Rechercher"
        aria-label="Search"
        aria-describedby="search-addon"
        v-model="searchProduct"
      />
    </div>


          <!-----------------------------------------------add assignment------------------------------------------>

          <div class="modal fade" id="addAssignment" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i
                      class="fa-solid fa-pen fa-xl"
                      style="margin-right: 10px"
                    ></i>
                    <h5 class="modal-title mb-0" id="addAssignmentLabel">
                      Affecter une pompe
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
                  <form @submit.prevent="addAssignment()">
                    <div class="row gx-3 mb-3">
                      <div class="col-md-12">
                        <label
                          class="small mb-1"
                          for="type_prod"
                          style="float: left"
                          >Pompes</label
                        >
                        <select
                          class="form-select"
                          id="type_prod"
                          v-model="product"
                          required
                        >
                          <option
                            v-for="product in products"
                            :key="product.id"
                            :value="product.id"
                          >
                            {{ product.name }}
                          </option>
                        </select>
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
                          class="form-control"
                          id="Année"
                          type="text"
                          placeholder="Entrer le temps de changement d'huile"
                          v-model="c_huile"
                        />
                      </div>
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="time_day"
                          style="float: left"
                          >Changement des cartouches de filtres</label
                        >
                        <input
                          class="form-control"
                          id="time_day"
                          type="text"
                          placeholder="Entrer le temps de changement de filtre"
                          v-model="c_filtre"
                        />
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
                          class="form-control"
                          id="Année"
                          type="text"
                          placeholder="Entrer le temps de changement des déshuileurs"
                          v-model="c_dehuil"
                        />
                      </div>
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="inputOrgName"
                          style="float: left"
                          >Entretien</label
                        >
                        <input
                          class="form-control"
                          id="inputOrgName"
                          type="text"
                          placeholder="Entrer le temps d'entretien"
                          v-model="entretien"
                        />
                      </div>
                    </div>
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

          <!----------------------------------------------- End Edit Assignment------------------------------------------>

          <!-----------------------------------------------Edit assignment------------------------------------------>

          <div class="modal fade" id="editAssignment" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i
                      class="fa-solid fa-pen fa-xl"
                      style="margin-right: 10px"
                    ></i>
                    <h5 class="modal-title mb-0" id="editAssignmentLabel">
                      Modifier la pompe
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
                  <form @submit.prevent="updateAssignment(AssignmentEdit)">
                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="type_prod"
                          style="float: left"
                          >Client</label
                        >
                        <select
                          class="form-select"
                          id="client"
                          aria-label="Default select example"
                          v-model="client"
                          disabled
                        >
                          <option :value="clientId" disabled selected>
                            {{ society }}
                          </option>
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="type_prod"
                          style="float: left"
                          >Pompes</label
                        >
                        <select
                          class="form-select"
                          id="type_prod"
                          aria-label="Default select example"
                          v-model="productEdit"
                          required
                        >
                          <option
                            v-for="product in products"
                            :key="product.id"
                            :value="product.id"
                          >
                            {{ product.name }}
                          </option>
                        </select>
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
                          class="form-control"
                          id="Année"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement d'huile"
                          v-model="c_huileEdit"
                        />
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="time_day"
                          style="float: left"
                          >Changement des cartouches de filtres</label
                        >
                        <input
                          class="form-control"
                          id="time_day"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement de filtre"
                          v-model="c_filtreEdit"
                        />
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
                          class="form-control"
                          id="Année"
                          rows="4"
                          type="text"
                          placeholder="Entrer le temps de changement des déshuileurs"
                          v-model="c_dehuilEdit"
                        />
                      </div>

                      <div class="col-md-6">
                        <label
                          class="small mb-1"
                          for="inputOrgName"
                          style="float: left"
                          >Entretien</label
                        >
                        <input
                          class="form-control"
                          id="inputOrgName"
                          type="text"
                          placeholder="Entrer le temps d'entretien"
                          v-model="entretienEdit"
                        />
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

          <!----------------------------------------------- End Edit Assignment------------------------------------------>

          <!-----------------------------------------------show Assignment------------------------------------------>

          <div class="modal fade" id="showAssignment" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex align-items-center">
                    <i
                      class="fa-solid fa-pen fa-xl"
                      style="margin-right: 10px"
                    ></i>
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
                        <div class="mb-3">
                          <label
                            class="small mb-1"
                            for="name"
                            style="float: left"
                            >Pompe</label
                          >
                          <input
                            class="form-control"
                            id="name"
                            type="text"
                            v-model="productShow"
                            disabled
                          />
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label
                                class="small mb-1"
                                for="debit"
                                style="float: left"
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
                          </div>
                          <div class="col-md-6">
                            <div class="mb-3">
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
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label
                                class="small mb-1"
                                for="annee"
                                style="float: left"
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
                          </div>
                          <div class="col-md-6">
                            <div class="mb-3">
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
        </div>
      </div>
      <br />

      <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
          <i class="fa-solid fa-industry me-2"></i>
          <h5 class="mb-0">Parc {{ society }}</h5>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">CODE GSI</th>
                <th scope="col">Nom</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(assignment, index) in displayedAssignmentsSlice"
                :key="index"
              >
                <th v-if="assignment.product[0].id">
                  #{{ assignment.product[0].id }}
                </th>
                <td v-if="assignment.product[0].name">
                  {{ assignment.product[0].name }}
                </td>
                <td v-if="assignment.product[0].image">
                  <img
                    :src="'/storage/img/pompes/' + assignment.product[0].image"
                    width="100"
                  />
                </td>
                <td>
                  <a
                    id="crudBtn"
                    class="me-4 text-info"
                    @click="openShowModal(assignment)"
                  >
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a
                    id="crudBtn"
                    @click="openEditModal(assignment)"
                    class="me-4 text-warning"
                  >
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <a
                    id="crudBtn"
                    @click="deleteAssignment(assignment.id)"
                    class="text-danger"
                  >
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
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
import { onMounted, ref, computed, watchEffect } from "vue";
import { useRoute } from "vue-router";
import Swal from "sweetalert2";
import axios from "axios";
window.Swal = Swal;

const route = useRoute();
const assignmentId = route.params.id;
let currentPage = ref(1);
let itemsPerPage = ref(5);

onMounted(async () => {
  get_all_products();
  get_assignments();
});

const assignmentsValue = ref([]);
const society = ref("");
const clientId = ref("");
let searchProduct = ref([]);
let products = ref([]);

const get_assignments = async () => {
  try {
    let response = await axios.get(`/api/get_assignments/${assignmentId}`);
    console.log(response.data);

    assignmentsValue.value = response.data.assignments.assignments;
    society.value = response.data.assignments.client[0].society;
    clientId.value = response.data.assignments.client[0].id;

    console.log(assignmentsValue.value);
  } catch (error) {
    route.push("/parc_clients");
  }
};

const get_all_products = async () => {
  try {
    let response = await axios.get("/api/get_all_products");
    console.log(response.data);
    products.value = response.data.products;
  } catch (error) {
    console.error(error);
  }
};

const displayedAssignments = computed(() => {
  // Filter assignments based on the search input
  return assignmentsValue.value.filter((assignment) => {
    const productName = assignment.product[0]?.name || "";
    const productId = assignment.product[0]?.id || "";
    return (
      productName.includes(searchProduct.value) ||
      productId.toString().includes(searchProduct.value)
    );
  });
});

//Page numbers
const displayedAssignmentsSlice = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return displayedAssignments.value.slice(startIndex, endIndex);
});

const totalPages = computed(() =>
  Math.ceil(displayedAssignments.value.length / itemsPerPage.value)
);

const changePage = (page) => {
  currentPage.value = page;
};
</script>


    <script>
export default {
  name: "parc",
  //check auth
  beforeRouteEnter(to, from, next) {
    if (checkLoginAdmin()) {
      next();
    } else {
      next("/login");
    }
  },

  props: {
    itemsPerPage: Number,
    currentPage: Number,
    totalPages: Number,
    id: {
      required: true,
    },
  },
  data() {
    return {
      client: "",
      society: "",
      clientId: "",
      name: "",
      index: 0,
      //Add
      clientAdd: "",
      product: "",
      c_huile: "",
      c_filtre: "",
      c_dehuil: "",
      entretien: "",

      //Edit
      AssignmentEdit: {},
      productEdit: "",
      c_huileEdit: "",
      c_filtreEdit: "",
      c_dehuilEdit: "",
      entretienEdit: "",

      //show
      assignmentShow: {},
      productShow: "",
      codeShow: "",
      c_huileShow: "",
      c_filtreShow: "",
      c_dehuilShow: "",
      entretienShow: "",
      imageShow: "",
    };
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

  mounted() {
    this.get_assignments();
  },

  methods: {
    changePage(page) {
      this.$emit("page-change", page);
    },

    addAssignment() {
      try {
        this.clientAdd = this.clientId;
        let form = new FormData();
        form.append("client_id", this.clientAdd);
        form.append("product_id", this.product);
        form.append("c_huile", this.c_huile);
        form.append("c_filtre", this.c_filtre);
        form.append("c_dehuil", this.c_dehuil);
        form.append("entretien", this.entretien);
        axios.post(`/api/assignments/create`, form);
        console.log(form);
        this.product = "";
        this.c_huile = "";
        this.c_filtre = "";
        this.c_dehuil = "";
        this.entretien = "";

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
        $(".modal-backdrop").hide();

        this.$router.push("/parc_clients");
        window.location.reload();
      } catch (error) {
        console.log(error);
      }
    },

    openEditModal(assignment) {
      $("#editAssignment").modal("show");
      const selectedIndex = 0;
      const selectedValue = $("#client option:eq(" + selectedIndex + ")").val();
      this.client = selectedValue;
      this.AssignmentEdit = assignment;
      this.productEdit = assignment.product[0].id;
      this.c_huileEdit = assignment.c_huile;
      this.c_filtreEdit = assignment.c_filtre;
      this.c_dehuilEdit = assignment.c_dehuil;
      this.entretienEdit = assignment.entretien;
    },

    openShowModal(assignment) {
      $("#showAssignment").modal("show");
      try {
        axios
          .get(`/api/assignments/show/${assignment.id}`)
          .then((response) => {
            this.assignmentShow = response.data.assignment;
            this.productShow = this.assignmentShow.product[0].name;
            this.c_huileShow = this.assignmentShow.c_huile;
            this.c_filtreShow = this.assignmentShow.c_filtre;
            this.c_dehuilShow = this.assignmentShow.c_dehuil;
            this.entretienShow = this.assignmentShow.entretien;
            this.imageShow = this.assignmentShow.product[0].image;
          })
          .catch((error) => {
            console.error(error);
          });
      } catch (error) {
        console.error(error);
      }
    },

    updateAssignment(assignment) {
      try {
        axios.put(`/api/assignments/update/${assignment.id}`, {
          client_id: this.client,
          product_id: this.productEdit,
          c_huile: this.c_huileEdit,
          c_filtre: this.c_filtreEdit,
          c_dehuil: this.c_dehuilEdit,
          entretien: this.entretienEdit,
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
          title: "Attribution modifié avec succés!",
        });
        // $('#addUserModal').removeClass('show');

        $("#editAssignment").modal("hide");

        this.get_assignments();

        this.AssignmentEdit = {};
        this.productEdit = "";
        this.c_huileEdit = "";
        this.c_filtreEdit = "";
        this.c_dehuilEdit = "";
        this.entretienEdit = "";
      } catch (error) {
        console.log(error);
      }
    },

    deleteAssignment(assignment_id) {
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
            .post("/api/assignments/delete/" + assignment_id)
            .then((response) => {
              if (response.status === 200) {
                this.get_assignments();
                Swal.fire(
                  "Supprimé!",
                  "attachement a été supprimé!",
                  "success"
                );
              } else {
                this.$router.push("/parc_clients");
              }
              console.log(response);
            })
            .catch((error) => {
              console.log(error);
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
i.fa-regular.fa-circle-left:hover {
  color: #36b9cc;
}
</style>
