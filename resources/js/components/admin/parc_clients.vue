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
                @keyup="search_society()"

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







            <!-----------------------------------------------Edit assignment------------------------------------------>

            <div class="modal fade" id="editAssignment" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px;"></i>
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
                    <form @submit.prevent="updateAssignment(AssignmentEdit)" >

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
                                v-model="clientEdit"
                                required
                            >
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
                            v-model="c_filtreEdit"
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
                            v-model="c_dehuilEdit"
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
                            v-model="entretienEdit"
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
                        Modifier
                        </button>
                        </div>

                    </form>


                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Edit Assignment------------------------------------------>

            <!-- Start List products -->
            <!-- Modal -->
            <div class="modal fade" id="openProductsModal" tabindex="-1" aria-labelledby="openProductsModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paginationModalLabel">Pagination Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content of the modal goes here -->
                    <div id="page1" class="page">
                    Page 1 Content
                    </div>
                    <div id="page2" class="page" style="display: none;">
                    Page 2 Content
                    </div>
                    <div id="page3" class="page" style="display: none;">
                    Page 3 Content
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Previous and Next buttons -->
                    <button type="button" class="btn btn-secondary" id="prevBtn">Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                </div>
                </div>
            </div>
            </div>
            <!-- End list products -->


            <!-----------------------------------------------show Assignment------------------------------------------>

            <div class="modal fade" id="showAssignment" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px;"></i>
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

          <div class="row gx-3 mb-3">
            <div class="col-md-8">
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1" for="name" style="float: left">Pompe</label>
                  <input class="form-control" id="name" type="text"  v-model="productShow" disabled>
                </div>

                <div class="col-md-6">
                  <label class="small mb-1" for="type" style="float: left">CODE GSI</label>
                  <input class="form-control" id="type" type="text"  v-model="codeShow" disabled>
                </div>

              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6" >
                  <label class="small mb-1" for="debit" style="float: left">Changement d'huile</label>
                  <input class="form-control" id="debit" type="text"  v-model="c_huileShow" disabled>
                </div>
                <div class="col-md-6" >
                  <label class="small mb-1" for="pression" style="float: left">Changement des cartouches de filtres</label>
                  <input class="form-control" id="pression" type="text" v-model="c_filtreShow" disabled>
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6" >
                  <label class="small mb-1" for="annee" style="float: left">Changement des déshuileurs</label>
                  <input class="form-control" id="annee" type="text"  v-model="c_dehuilShow" disabled>
                </div>
                <div class="col-md-6" v-if="!entretienShow">
                  <label class="small mb-1" for="time_day" style="float: left">Entretien Génerale</label>
                  <input class="form-control" id="time_day" type="text"  v-model="entretienShow" disabled>
                </div>
              </div>
            </div>


            <div class="col-md-4">
  <div class="d-flex align-items-center justify-content-center h-100">
    <div class="border border-secondary image">
      <img :src="'/storage/img/pompes/' + imageShow" class="centered-image"/>
    </div>
  </div>
</div>



          </div>
          <div class="modal-footer">
                    <!-- Previous and Next buttons -->
                    <button type="button" class="btn btn-secondary" id="prevBtn">Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn"  @click="nextAssignment(Index)">Next</button>
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
          <tbody v-if="assignments.length > 0">
            <tr v-for="(assignment,index) in displayedassignments" :key="index" id="crudBtn" @click="ShowAssignments(index)" >
              <td v-if="assignment.client">{{ assignment.client[0].society  }}</td>
              <th ><i class="fa-solid fa-chevron-right fa-lg text-dark"></i></th>
            </tr>
              <!-- <td v-if="assignment.product"><img :src="'/storage/img/pompes/'+assignment.product.image" width="100" /></td> -->
            <!-- <td>
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
                <a id="crudBtn" @click="deleteAssignment(assignment.id)" class="text-danger">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td> -->
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
  import Select2 from 'vue3-select2-component';
  window.Swal = Swal;

  let assignments=ref([]);
  let clients = ref([]);
  let products = ref([]);


  let type_products = ref([]);
  let searchSociety = ref([]);

  const currentPage = ref(1);
  const itemsPerPage = ref(5); // Set the default number of items per page


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


  const search_society = async () => {
    let response = await axios.get("/api/assignments/search_society?s=" + searchSociety.value);
    console.log("response", response);
    assignments.value = response.data.assignments;
  };


  //Page numbers
  const displayedassignments = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return assignments.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(assignments.value.length / itemsPerPage.value)
  );

  const changePage = (page) => {
    currentPage.value = page;
  };
  </script>


    <script>
  export default {
      name: "products",
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

        //Edit
        AssignmentEdit: {},
        clientEdit: "",
        productEdit:"",
        c_huileEdit:"",
        c_filtreEdit:"",
        c_dehuilEdit:"",
        entretienEdit:"",


        //show
        assignmentShow: {},
        clientShow: "",
        productShow:"",
        codeShow:"",
        c_huileShow:"",
        c_filtreShow:"",
        c_dehuilShow:"",
        entretienShow:"",
        imageShow:"",

        Index:0,
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

      changePage(page) {
        this.$emit("page-change", page);
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

      openEditModal(assignment) {
        $("#editAssignment").modal("show");
        this.AssignmentEdit=assignment;
        this.clientEdit=assignment.client.id;
        this.productEdit=assignment.product.id;
        this.c_huileEdit=assignment.c_huile;
        this.c_filtreEdit=assignment.c_filtre;
        this.c_dehuilEdit=assignment.c_dehuil;
        this.entretienEdit=assignment.entretien;
          },


    updateAssignment(assignment) {
      try {
        axios.put(`/api/assignments/update/${assignment.id}`, {
            client_id: this.clientEdit,
            product_id: this.productEdit,
            c_huile: this.c_huileEdit,
            c_filtre:this.c_filtreEdit,
            c_dehuil:this.c_dehuilEdit,
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

        this.get_all_assignments();

      this.AssignmentEdit = {};
      this.productEdit="";
      this.c_huileEdit="";
      this.c_filtreEdit="";
      this.c_dehuilEdit="";
      this.entretienEdit="";
      } catch (error) {
        console.log(error);
      }
    },


openShowModal(assignment) {
  $("#showAssignment").modal("show");
    this.updateModalContent(assignment[this.Index]);


},

  updateModalContent(assignmentItem) {
      this.productShow = assignmentItem.product[0].name;
      this.codeShow = assignmentItem.product[0].id;
      this.c_huileShow = assignmentItem.c_huile;
      this.c_filtreShow = assignmentItem.c_filtre;
      this.c_dehuilShow = assignmentItem.c_dehuil;
      this.entretienShow = assignmentItem.entretien;
      this.imageShow = assignmentItem.product[0].image;
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
                  this.get_all_assignments();
                  console.log(response);
                  Swal.fire("Supprimé!", "attachement a été supprimé!", "success");
                })
                .catch((errors) => {
                  console.log(errors);
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
