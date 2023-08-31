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
                    <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="fa-sharp fa-solid fa-plus fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title col-11" id="addProductLabel">
                        Assigner une pompe au client
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
                    <form  @submit.prevent="createAssignment()">


                        <div class="row gx-3 mb-3">

                            <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="type_prod"
                                    style="float: left"
                                    >Clients</label
                                  >
                                  <select
                                    class="form-select"
                                    id="type_prod"
                                    aria-label="Default select example"
                                    v-model="client"
                                    required
                                  >
                                  <option value="" selected disabled hidden>Sélectionner un client</option>
                                        <option
                                        v-for="client in clients"
                                        :key="client.id"
                                        :value="client.id"
                                        >
                                        {{ client.society }}
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
                                    v-model="product"
                                    required
                                  >
                                  <option value="" selected disabled hidden>Sélectionner une pompe</option>
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
                                v-model="c_huile"
                                >
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
                                v-model="c_filtre"
                                >
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
                                v-model="c_dehuil"
                                >
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

            <!----------------------------------------------- End Create assignment------------------------------------------>

          </div>
        </div>
        <br />



        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-brands fa-product-hunt me-2"></i>
          <h5 class="mb-0">Parc Clients</h5>
          </div>

        <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Société</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody v-if="displayedAssignmentsSlice.length > 0">
  <tr v-for="(assignment,index) in displayedAssignmentsSlice" :key="index" id="crudBtn" @click="ShowAssignments(index)" >
    <td v-if="assignment.client">{{ assignment.client[0].society }}</td>
    <th ><i class="fa-solid fa-chevron-right fa-lg text-dark"></i></th>
  </tr>
</tbody>

          <tbody v-else>
            <p>Pas de parcs</p>
          </tbody>
        </table>
        </div>
        </div>

        <nav aria-label="User pagination" v-if="displayedPages.length > 1" class="pb-1">
    <ul class="pagination justify-content-end">
      <!-- Previous Page Button -->
      <li class="page-item" v-if="currentPage !== 1">
        <a class="page-link shadow" @click="changePage(currentPage - 1)">Précédent</a>
      </li>

      <!-- Page Numbers -->
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

      <!-- Next Page Button -->
      <li class="page-item" v-if="currentPage !== displayedPages.length">
        <a class="page-link shadow" @click="changePage(currentPage + 1)">Suivant</a>
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

  let assignments=ref([]);
  let clients = ref([]);
  let products = ref([]);

  onMounted(async () => {
    get_all_assignments();
    get_all_products();
    get_all_clients();
  });

  const get_all_assignments = async () => {
    try {
      let response = await axios.get("/api/get_all_assignments");
      console.log(response.data);
      assignments.value = response.data.assignments;
    } catch (error) {
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
        client: "",
        product:"",
        c_huile:"",
        c_filtre:"",
        c_dehuil:"",
        entretien:"",

        Index:0,
        searchSociety:[],
        currentPage: 1,
        itemsPerPage: 10,
      };
    },


    computed: {
displayedAssignments() {
      // Filter assignments based on the search input
      return this.assignments.filter(assignment => {
        const societyName = assignment.client[0]?.society || '';
        return societyName.includes(this.searchSociety);
      });
    },


    displayedPages() {
      const pageCount = Math.ceil(this.displayedAssignments.length / this.itemsPerPage);
      const range = [];

      for (let i = 1; i <= pageCount; i++) {
        range.push(i);
      }

      return range;
    },

    displayedAssignmentsSlice() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.displayedAssignments.slice(startIndex, endIndex);
    },

    },





    methods: {

      changePage(newPage) {
      if (newPage >= 1 && newPage <= this.displayedPages.length) {
        this.currentPage = newPage;
      }
    },

      uploadImage(e){
        this.image=e.target.files[0];
      },

      uploadImageEdit(e){
        this.imageEdit=e.target.files[0];
      },

      async createAssignment() {

        try {
            let form = new FormData();
            form.append('client_id', this.client);
            form.append('product_id', this.product);
            form.append('c_huile', this.c_huile);
            form.append('c_filtre',this.c_filtre);
            form.append('c_dehuil',this.c_dehuil);
            form.append('entretien', this.entretien);
          await axios.post(`/api/assignments/create`, form);
          console.log(form);
          this.client = "";
          this.product="";
          this.c_huile="";
          this.c_filtre="";
          this.c_dehuil="";
          this.entretien="";


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


        ShowAssignments(assignment) {
            this.$router.push({
                name: 'parc',
                params: { id: assignment },
                props: true
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
