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
                v-model="searchType"
                @keyup="search()"
              />
            </div>
          </div>
          <div class="col-md-8 text-end">
            <div class="text-end">
              <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addTypeIndustry"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create type_product------------------------------------------>

            <div class="modal fade" id="addTypeIndustry" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="fa-sharp fa-solid fa-plus fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title col-11" id="addTypeIndustryLabel">
                        Ajouter un nouvel type de produit
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

                    <form  @submit.prevent="createType()">
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
                          Ajouter
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Create type_product------------------------------------------>

            <!-----------------------------------------------Edit type_product------------------------------------------>

            <div class="modal fade" id="editTypeProduct" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title mb-0" id="editTypeProductLabel">
                        Modifier le type de produit
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
                                    placeholder="Entrer le nom du type "
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
          <h5 class="mb-0">Types de produits</h5>
      </div>


      <div class="table-responsive">
      <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nom</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody v-if="type_products.length > 0">
            <tr v-for="type_prod in displayedtype_products" :key="type_prod.id">
              <th scope="row">{{ type_prod.id }}</th>
              <td>{{ type_prod.name }}</td>
              <td>
                <a
                  id="crudBtn"
                  @click="openEditModal(type_prod)"
                  class="me-4 text-warning"
                >
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a id="crudBtn" @click="deleteType(type_prod.id)" class="text-danger">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <p>Pas de types de produits</p>
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
import layout from "../layouts/layout.vue";  import {
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

  let type_products = ref([]);
  let searchType = ref([]);

  const currentPage = ref(1);
  const itemsPerPage = ref(5); // Set the default number of items per page


  onMounted(async () => {
    get_all_types();
  });


  const get_all_types = async () => {
    try {
      let response = await axios.get("/api/get_type_products");
      console.log(response.data); // Log the response data
      type_products.value = response.data.type_products;
    } catch (error) {
      console.error(error);
    }
  };

  const search = async () => {
    let response = await axios.get("/api/types_product/search_type?s=" + searchType.value);
    console.log("response", response);
    type_products.value = response.data.type_products;
    type_products.value = response.data.type_products;
  };


  //Page numbers
  const displayedtype_products = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return type_products.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(type_products.value.length / itemsPerPage.value)
  );

  const changePage = (page) => {
    currentPage.value = page;
  };
  </script>


    <script>
  export default {
      name: "types_produits",
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
        type_prod: {},
        typeEdit: {},
        name: "",



      };
    },

    props: {
      type_products: Array,
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


      changePage(page) {
        this.$emit("page-change", page);
      },


      async createType() {
        try {
          await axios.post(`/api/types_product/create`, {
            name: this.name,
          });
          this.name = "";

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
            title: "Element ajouté avec succés !",
          });
          // $('#addUserModal').removeClass('show');

          $("#addTypeIndustry").modal("hide");
          $(".modal-backdrop").hide();

          this.$router.push("/types_product");
          window.location.reload();
        } catch (error) {
          console.log(error);
        }
      },


      openEditModal(type_prod) {
        $("#editTypeProduct").modal("show");
        this.name = type_prod.name;
        this.typeEdit=type_prod;
          },

      updateType(type_prod) {
        try {
          axios.put(`/api/types_product/update/${type_prod.id}`, {
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

          $("#editTypeProduct").modal("hide");
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
                .post("/api/types_product/delete/" + type_id)
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
