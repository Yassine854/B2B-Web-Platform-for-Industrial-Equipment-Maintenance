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
                v-model="searchProduct"
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
                data-bs-target="#addProduct"
              >
              <i class="fa-solid fa-plus"></i>
              </button>
            </div>

            <!-----------------------------------------------Create product------------------------------------------>

            <div class="modal fade" id="addProduct" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="fa-sharp fa-solid fa-plus fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title col-11" id="addProductLabel">
                        Ajouter une nouvelle Pompe
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

                    <form  @submit.prevent="createProduct()">

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
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
                                type="text"
                                placeholder="Entrer le nom du pompe"
                                v-model="name"
                                required
                                >
                            </div>

                            <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="type_prod"
                                    style="float: left"
                                    >Type de produit</label
                                  >
                                  <select
                                    class="form-select"
                                    id="type_prod"
                                    aria-label="Default select example"
                                    v-model="type_prod"
                                    required
                                  >
                                        <option
                                        v-for="types in type_products"
                                        :key="types.id"
                                        :value="types.id"
                                        >
                                        {{ types.name }}
                                        </option>
                                  </select>
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <div class="row gx-3 mb-6">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="debit" style="float: left">Débit</label>
                                        <input
                                            class="form-control"
                                            id="debit"
                                            type="text"
                                            placeholder="Entrer le débit"
                                            v-model="debit"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-4">
                                    <label class="small mb-1" for="flow-rate" style="float: left">Unité</label>
                                    <select id="flow-rate" class="form-select" v-model="unity_debit" required>
                                        <option value="m³/h">m³/h</option>
                                        <option value="l/s">l/s</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label
                                class="small mb-1"
                                for="Pression"
                                style="float: left"
                                >Pression</label
                                >
                                <input
                                class="form-control"
                                id="Pression"
                                rows="4"
                                type="text"
                                placeholder="Entrer la pression"
                                v-model="pression"
                                required
                                >
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label
                                class="small mb-1"
                                for="Année"
                                style="float: left"
                                >Année</label
                                >
                                <input
                                class="form-control"
                                id="Année"
                                rows="4"
                                type="text"
                                placeholder="Entrer l'année"
                                v-model="year"
                                required
                                >
                            </div>

                            <div class="col-md-6">
                                <label
                                class="small mb-1"
                                for="time_day"
                                style="float: left"
                                >HT/J</label
                                >
                                <input
                                class="form-control"
                                id="time_day"
                                rows="4"
                                type="text"
                                placeholder="Entrer l'heure du travail"
                                v-model="time_day"
                                required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                        <label for="image" class="form-label" style="float: left">Image</label>
                        <input @change="uploadImage" class="form-control" type="file" id="image">
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

            <!----------------------------------------------- End Create product------------------------------------------>

            <!-----------------------------------------------Edit product------------------------------------------>

            <div class="modal fade" id="editProduct" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px;"></i>
                    <h5 class="modal-title mb-0" id="editProductLabel">
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
                    <form @submit.prevent="updateProduct(productEdit)" >

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
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
                                type="text"
                                placeholder="Entrer le nom du pompe"
                                v-model="nameEdit"
                                required
                                >
                            </div>

                            <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="type_prod"
                                    style="float: left"
                                    >Type de produit</label
                                  >
                                  <select
                                    class="form-select"
                                    id="type_prod"
                                    aria-label="Default select example"
                                    v-model="type_prodEdit"
                                    required
                                  >
                                        <option
                                        v-for="types in type_products"
                                        :key="types.id"
                                        :value="types.id"
                                        >
                                        {{ types.name }}
                                        </option>
                                  </select>
                            </div>
                        </div>

                            <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <div class="row gx-3 mb-6">
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="debit" style="float: left">Débit</label>
                                        <input
                                            class="form-control"
                                            id="debit"
                                            type="text"
                                            placeholder="Entrer le débit"
                                            v-model="debitEdit"
                                            required
                                        >
                                    </div>
                                    <div class="col-md-4">
                                    <label class="small mb-1" for="flow-rate" style="float: left">Unité</label>
                                    <select id="flow-rate" class="form-select" v-model="unity_debitEdit" required>
                                        <option value="m³/h">m³/h</option>
                                        <option value="l/s">l/s</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label
                                class="small mb-1"
                                for="Pression"
                                style="float: left"
                                >Pression</label
                                >
                                <input
                                class="form-control"
                                id="Pression"
                                rows="4"
                                type="text"
                                placeholder="Entrer la pression"
                                v-model="pressionEdit"
                                required
                                >
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label
                                class="small mb-1"
                                for="Année"
                                style="float: left"
                                >Année</label
                                >
                                <input
                                class="form-control"
                                id="Année"
                                rows="4"
                                type="text"
                                placeholder="Entrer l'année"
                                v-model="yearEdit"
                                required
                                >
                            </div>

                            <div class="col-md-6">
                                <label
                                class="small mb-1"
                                for="time_day"
                                style="float: left"
                                >HT/J</label
                                >
                                <input
                                class="form-control"
                                id="time_day"
                                rows="4"
                                type="text"
                                placeholder="Entrer l'heure du travail"
                                v-model="time_dayEdit"
                                required
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                        <label for="imageEdit" class="form-label" style="float: left">Image</label>
                        <input  @change="uploadImageEdit" class="form-control" type="file" id="imageEdit">
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
                             Modifier
                        </button>
                      </div>

                    </form>


                  </div>
                </div>
              </div>
            </div>

            <!----------------------------------------------- End Edit product------------------------------------------>


            <!-----------------------------------------------show product------------------------------------------>

            <div class="modal fade" id="showProduct" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-pen fa-xl" style="margin-right: 10px;"></i>
          <h5 class="modal-title mb-0" id="editProductLabel">
            Détails de la pompe
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
                <label class="small float-left" for="name">Nom</label>
                <input class="form-control" id="name" type="text" v-model="nameShow" disabled>
              </div>
              <div class="mb-3">
                <label class="small float-left" for="type">Type</label>
                <input class="form-control" id="type" type="text" v-model="type_prodShow" disabled>
              </div>
              <div class="mb-3">
                <label class="small float-left" for="debit">Débit</label>
                <input class="form-control" id="debit" type="text" v-model="debitShow" disabled>
              </div>
              <div class="mb-3">
                <label class="small float-left" for="pression">Pression</label>
                <input class="form-control" id="pression" type="text" v-model="pressionShow" disabled>
              </div>
              <div class="mb-3">
                <label class="small float-left" for="annee">Année</label>
                <input class="form-control" id="annee" type="text" v-model="yearShow" disabled>
              </div>
              <div class="mb-3">
                <label class="small float-left" for="time_day">HT/J</label>
                <input class="form-control" id="time_day" type="text" v-model="time_dayShow" disabled>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center justify-content-center h-100">
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



            <!----------------------------------------------- End show product------------------------------------------>


          </div>
        </div>
        <br />

        <div class="card mb-4">
          <div class="card-header d-flex align-items-center">
            <i class="fa-brands fa-product-hunt me-2"></i>
          <h5 class="mb-0">Liste des pompes</h5>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">CODE GSI</th>
              <th scope="col">Nom</th>
              <th scope="col">Image</th>
              <th scope="col">Type</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody v-if="products.length > 0">
            <tr v-for="product in displayedproducts" :key="product.id">
              <th scope="row">#{{ product.id }}</th>
              <td>{{ product.name }}</td>
              <td><img :src="'/storage/img/pompes/'+product.image" width="100" /></td>
              <td v-if="product.type">{{ product.type.name }}</td>
              <td v-else></td>
              <td>
                <a
                id="crudBtn"
                class="me-4 text-info"
                @click="openShowModal(product)"
              >
                <i class="fa-solid fa-eye"></i>
              </a>
                <a
                  id="crudBtn"
                  @click="openEditModal(product)"
                  class="me-4 text-warning"
                >
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a id="crudBtn" @click="deleteProduct(product.id)" class="text-danger">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <p>Pas de pompes</p>
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
  window.Swal = Swal;

  let products = ref([]);
  let type_products = ref([]);
  let searchProduct = ref([]);

  const currentPage = ref(1);
  const itemsPerPage = ref(5); // Set the default number of items per page


  onMounted(async () => {
    get_products();
    get_all_types();
  });

  const get_products = async () => {
    try {
      let response = await axios.get("/api/get_products");
      console.log(response.data); // Log the response data
      products.value = response.data.products;
    } catch (error) {
      console.error(error);
    }
  };


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
    let response = await axios.get("/api/products/search_product?s=" + searchProduct.value);
    console.log("response", response);
    products.value = response.data.products;
  };


  //Page numbers
  const displayedproducts = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return products.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(products.value.length / itemsPerPage.value)
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
        product: {},
        name: "",
        type_prod:"",
        debit:"",
        pression:"",
        year:"",
        time_day:"",
        image:null,
        unity_debit:"",

        //Edit
        productEdit: {},
        nameEdit: "",
        type_prodEdit:"",
        debitEdit:"",
        pressionEdit:"",
        yearEdit:"",
        time_dayEdit:"",
        imageEdit:null,
        unity_debitEdit:"",

        //show
        productShow: {},
        nameShow: "",
        type_prodShow:"",
        debitShow:"",
        pressionShow:"",
        yearShow:"",
        time_dayShow:"",
        imageShow:null,
        unity_debitShow:"",

      };
    },

    props: {
      products: Array,
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

      async createProduct() {
        console.log(this.image);
        try {
            let form = new FormData();
            form.append('name', this.name);
            form.append('type_prod', this.type_prod);
            form.append('debit', this.debit);
            form.append('unity_debit',this.unity_debit);
            form.append('pression', this.pression);
            form.append('year', this.year);
            form.append('time_day', this.time_day);
            form.append('image', this.image);
          await axios.post(`/api/products/create`, form);
          console.log(form);
          this.name = "";
          this.type_prod="";
          this.debit="";
          this.pression="";
          this.year="";
          this.time_day="";
          this.image="";
          this.unity_debit="";

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
            title: "Pompe ajouté avec succés !",
          });
          $("#addProduct").modal("hide");
          $(".modal-backdrop").hide();

          this.$router.push("/products");
          window.location.reload();
        } catch (error) {
          console.log(error);
        }
      },

      openEditModal(product) {
        $("#editProduct").modal("show");
        this.productEdit=product;
        this.nameEdit = product.name;
        this.type_prodEdit=product.type_prod;
        this.debitEdit=product.debit;
        this.unity_debitEdit=product.unity_debit;
        this.pressionEdit=product.pression;
        this.yearEdit=product.year;
        this.time_dayEdit=product.time_day;
        this.imageEdit=product.image;

          },

updateProduct(product) {
  try {
    let formEdit = new FormData();
    formEdit.append('name', this.nameEdit);
    formEdit.append('type_prod', this.type_prodEdit);
    formEdit.append('debit', this.debitEdit);
    formEdit.append('unity_debit', this.unity_debitEdit);
    formEdit.append('pression', this.pressionEdit);
    formEdit.append('year', this.yearEdit);
    formEdit.append('time_day', this.time_dayEdit);
    formEdit.append('image', this.imageEdit);
    axios({
      method: 'post',
      url: `/api/products/update/${product.id}`,
      data: formEdit,
      headers: {
        'Content-Type': 'multipart/form-data', // Set proper content type
      }
    }).then(response => {
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
        title: "Pompe modifié avec succés!",
      });

      $("#editProduct").modal("hide");
      $(".modal-backdrop").hide();

      this.get_products();
    //   this.$router.push("/products");
      this.productEdit = {};
      this.nameEdit = "";
      this.type_prodEdit = "";
      this.debitEdit = "";
      this.pressionEdit = "";
      this.yearEdit = "";
      this.time_dayEdit = "";
      this.imageEdit = "";
      this.unity_debitEdit="";
    }).catch(error => {
      console.log(error);
    });
  } catch (error) {
    console.log(error);
  }
},

openShowModal(product) {
  $("#showProduct").modal("show");
  try {
    axios.get(`/api/products/show/${product.id}`)
      .then(response => {
        this.showProduct = response.data.product;
        this.productShow=product;
        this.nameShow=this.showProduct.name;
        this.type_prodShow=this.showProduct.type.name;
        this.debitShow=this.showProduct.debit+' '+this.showProduct.unity_debit;
        this.pressionShow=this.showProduct.pression+" mbar";
        this.yearShow=this.showProduct.year;
        this.time_dayShow=this.showProduct.time_day+' H';
        this.imageShow=this.showProduct.image;

        console.log(this.showProduct);
      })
      .catch(error => {
        console.error(error);
      });
  } catch (error) {
    console.error(error);
  }
},

      deleteProduct(prod_id) {
        console.log(prod_id);
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
                .post("/api/products/delete/" + prod_id)
                .then((response) => {
                Swal.fire("Supprimé!", "Pompe a été supprimé!", "success");
                  this.get_products();
                  console.log(response);
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

  .image {
  width: 400px;
  height: 400px;
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
  max-width: 300px;
  max-height: 300px;
}

  </style>
