<template>
  <SideBar ref="table">
    <h5>Utilisateurs</h5>
    <br />
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
              placeholder="Search"
              aria-label="Search"
              aria-describedby="search-addon"
              v-model="searchUser"
              @keyup="search()"
            />
            <span class="input-group-text border-0" id="search-addon">
              <i class="fas fa-search"></i>
            </span>
          </div>
        </div>
        <div class="col-md-8 text-end">
          <div class="text-end">
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#addUserModal"
            >
              Ajouter
            </button>
          </div>

          <!-----------------------------------------------Create User------------------------------------------>

          <div class="modal fade" id="addUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <i class="fa-solid fa-user-plus fa-xl"></i>
                  <h5 class="modal-title" id="addUserModalLabel">
                    Ajouter un nouvel utilisateur
                  </h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <!-- First form content here (existing form) -->
                  <form>
                    <div class="mb-3">
                      <label
                        for="role"
                        class="form-label text-end"
                        style="float: left"
                        >Role</label
                      >
                      <select
                        class="form-select"
                        name="role"
                        aria-label="Defaultstartf select example"
                        v-model="selectRole"
                      >
                        <option value="1">Client</option>
                        <option value="2">Admin</option>
                      </select>
                    </div>
                  </form>

                  <!-- Client form -->
                  <form v-if="startForm() == false">
                    <div class="mb-3">
                      <div
                        class="accordion"
                        id="accordionPanelsStayOpenExample"
                      >
                        <div class="accordion-item">
                          <h2
                            class="accordion-header"
                            id="panelsStayOpen-headingOne"
                          >
                            <button
                              class="accordion-button"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#panelsStayOpen-collapseOne"
                              aria-expanded="true"
                              aria-controls="panelsStayOpen-collapseOne"
                            >
                              Inscription du compte
                            </button>
                          </h2>
                          <div
                            id="panelsStayOpen-collapseOne"
                            class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne"
                          >
                            <div class="accordion-body">
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputOrgName"
                                  style="float: left"
                                  >Nom d'utilisateur</label
                                >
                                <input
                                  class="form-control"
                                  id="inputOrgName"
                                  type="text"
                                  placeholder="Entrer le nom d'utilisateur"
                                  v-model="nameClient"
                                />
                              </div>
                              <!-- Form Group (location)-->
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputLocation"
                                  style="float: left"
                                  >Adresse E-mail</label
                                >
                                <input
                                  class="form-control"
                                  id="inputLocation"
                                  type="text"
                                  placeholder="Entrer l'adresse E-mail"
                                  v-model="emailClient"
                                />
                              </div>
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputLocation"
                                  style="float: left"
                                  >Mot de passe</label
                                >
                                <input
                                  class="form-control"
                                  id="inputLocation"
                                  type="password"
                                  v-model="passwordClient"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2
                            class="accordion-header"
                            id="panelsStayOpen-headingTwo"
                          >
                            <button
                              class="accordion-button collapsed"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#panelsStayOpen-collapseTwo"
                              aria-expanded="false"
                              aria-controls="panelsStayOpen-collapseTwo"
                            >
                              Détails du compte
                            </button>
                          </h2>
                          <div
                            id="panelsStayOpen-collapseTwo"
                            class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-headingTwo"
                          >
                            <div class="accordion-body">
                              <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputFirstName"
                                    style="float: left"
                                    >Société</label
                                  >
                                  <input
                                    class="form-control"
                                    id="inputFirstName"
                                    type="text"
                                    placeholder="Entrer le nom de votre société"
                                    v-model="society"
                                  />
                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLastName"
                                    style="float: left"
                                    >Type industrie</label
                                  >
                                  <select
                                    class="form-select"
                                    id="inputLastName"
                                    aria-label="Default select example"
                                    v-model="type_ind"
                                  >
                                    <option
                                      v-for="industrie in type_industries"
                                      :key="industrie.id"
                                      :value="industrie.id"
                                    >
                                      {{ industrie.name }}
                                    </option>
                                  </select>
                                </div>
                              </div>

                              <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputOrgName"
                                    style="float: left"
                                    >Résponsable</label
                                  >
                                  <input
                                    class="form-control"
                                    id="inputOrgName"
                                    type="text"
                                    placeholder="Entrer le nom du répsponsable"
                                    v-model="responsable"
                                  />
                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLocation"
                                    style="float: left"
                                    >Numéro du résponsable</label
                                  >
                                  <input
                                    class="form-control"
                                    id="inputLocation"
                                    type="text"
                                    placeholder="Entrer le numéro du répsponsable"
                                    v-model="N_responsable"
                                  />
                                </div>
                              </div>
                              <SelectCountryStateCity
                                @countryStateChanged="handleCountryStateChanged"
                              />

                              <div class="mb-3">
                                <label
                                  class="small mb-1"
                                  for="inputUsername"
                                  style="float: left"
                                  >Adresse</label
                                >
                                <textarea
                                  class="form-control"
                                  id="inputUsername"
                                  rows="4"
                                  placeholder="Entrer votre adresse"
                                  v-model="address"
                                ></textarea>
                              </div>
                            </div>
                          </div>
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
                        <button
                          type="button"
                          class="btn btn-primary"
                          @click="createClient"
                        >
                          Ajouter client
                        </button>
                      </div>
                      <!-- ... (other fields and inputs for the client form) ... -->
                    </div>
                  </form>
                  <!-- Admin form -->
                  <form v-if="startForm() == true">
                    <!-- Form Group (organization name)-->
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputOrgName"
                        style="float: left"
                        >Nom d'utilisateur</label
                      >
                      <input
                        class="form-control"
                        id="inputOrgName"
                        type="text"
                        placeholder="Entrer le nom d'utilisateur"
                        v-model="nameAdmin"
                      />
                    </div>
                    <!-- Form Group (location)-->
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputLocation"
                        style="float: left"
                        >Adresse E-mail</label
                      >
                      <input
                        class="form-control"
                        id="inputLocation"
                        type="text"
                        placeholder="Entrer l'adresse E-mail"
                        v-model="emailAdmin"
                      />
                    </div>
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputLocation"
                        style="float: left"
                        >Mot de passe</label
                      >
                      <input
                        class="form-control"
                        id="inputLocation"
                        type="password"
                        v-model="passwordAdmin"
                      />
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
                        type="button"
                        class="btn btn-primary"
                        @click="createAdmin()"
                      >
                        Ajouter
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!----------------------------------------------- End Create User------------------------------------------>

            <!-----------------------------------------------Edit User------------------------------------------>

            <div class="modal fade" id="editUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <i class="fa-solid fa-user-plus fa-xl"></i>
                  <h5 class="modal-title" id="addUserModalLabel">
                    Modifier l'utilisateur
                  </h5>
                  <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                  ></button>
                </div>
                <div class="modal-body">
                  <!-- First form content here (existing form) -->
                  <form>
                    <div class="mb-3">
                      <label
                        for="role"
                        class="form-label text-end"
                        style="float: left"
                        >Role</label
                      >
                      <select
                        class="form-select"
                        name="role"
                        id="role"
                        aria-label="Default select example"
                        v-model="selectRole"
                      >
                        <option value="1">Client</option>
                        <option value="2">Admin</option>
                      </select>
                    </div>
                  </form>

                  <!-- Client form -->
                  <form v-if="startForm() == false">
                    <div class="mb-3">
                      <div
                        class="accordion"
                        id="accordionPanelsStayOpenExample"
                      >
                        <div class="accordion-item">
                          <h2
                            class="accordion-header"
                            id="panelsStayOpen-headingOne"
                          >
                            <button
                              class="accordion-button"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#panelsStayOpen-collapseOne"
                              aria-expanded="true"
                              aria-controls="panelsStayOpen-collapseOne"
                            >
                              Inscription du compte
                            </button>
                          </h2>
                          <div
                            id="panelsStayOpen-collapseOne"
                            class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne"
                          >
                            <div class="accordion-body">
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputOrgName"
                                  style="float: left"
                                  ></label
                                >
                                <input
                                  class="form-control"
                                  id="inputOrgName"
                                  type="text"
                                  placeholder="Entrer le nom d'utilisateur"
                                  v-model="nameEdited"
                                />
                              </div>
                              <!-- Form Group (location)-->
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputLocation"
                                  style="float: left"
                                  >Adresse E-mail</label
                                >
                                <input
                                  class="form-control"
                                  id="inputLocation"
                                  type="text"
                                  placeholder="Entrer l'adresse E-mail"
                                  v-model="emailEdited"
                                />
                              </div>
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputLocation"
                                  style="float: left"
                                  >Mot de passe</label
                                >
                                <input
                                  class="form-control"
                                  id="inputLocation"
                                  type="password"
                                  v-model="passwordEdited"
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2
                            class="accordion-header"
                            id="panelsStayOpen-headingTwo"
                          >
                            <button
                              class="accordion-button collapsed"
                              type="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#panelsStayOpen-collapseTwo"
                              aria-expanded="false"
                              aria-controls="panelsStayOpen-collapseTwo"
                            >
                              Détails du compte
                            </button>
                          </h2>
                          <div
                            id="panelsStayOpen-collapseTwo"
                            class="accordion-collapse collapse"
                            aria-labelledby="panelsStayOpen-headingTwo"
                          >
                            <div class="accordion-body">
                              <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputFirstName"
                                    style="float: left"
                                    >Société</label
                                  >
                                  <input
                                    class="form-control"
                                    id="inputFirstName"
                                    type="text"
                                    placeholder="Entrer le nom de votre société"
                                    v-model="societyEdited"
                                  />
                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLastName"
                                    style="float: left"
                                    >Type industrie</label
                                  >
                                  <select
                                    class="form-select"
                                    id="inputLastName"
                                    aria-label="Default select example"
                                    v-model="type_indEdited"
                                  >
                                    <option
                                      v-for="industrie in type_industries"
                                      :key="industrie.id"
                                      :value="industrie.id"
                                    >
                                      {{ industrie.name }}
                                    </option>
                                  </select>
                                </div>
                              </div>

                              <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputOrgName"
                                    style="float: left"
                                    >Résponsable</label
                                  >
                                  <input
                                    class="form-control"
                                    id="inputOrgName"
                                    type="text"
                                    placeholder="Entrer le nom du répsponsable"
                                    v-model="responsableEdited"
                                  />
                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLocation"
                                    style="float: left"
                                    >Numéro du résponsable</label
                                  >
                                  <input
                                    class="form-control"
                                    id="inputLocation"
                                    type="text"
                                    placeholder="Entrer le numéro du répsponsable"
                                    v-model="N_responsableEdited"
                                  />
                                </div>
                              </div>
                              <SelectCountryStateCity
                                @countryStateChanged="handleCountryStateChanged"
                              />

                              <div class="mb-3">
                                <label
                                  class="small mb-1"
                                  for="inputUsername"
                                  style="float: left"
                                  >Adresse</label
                                >
                                <textarea
                                  class="form-control"
                                  id="inputUsername"
                                  rows="4"
                                  placeholder="Entrer votre adresse"
                                  v-model="addressEdited"
                                ></textarea>
                              </div>
                            </div>
                          </div>
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
                        <button
                          type="button"
                          class="btn btn-primary"
                          @click="updateUser()"
                        >
                          Modifier
                        </button>
                      </div>
                      <!-- ... (other fields and inputs for the client form) ... -->
                    </div>
                  </form>
                  <!-- Admin form -->
                  <form v-if="startForm() == true">
                    <!-- Form Group (organization name)-->
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputOrgName"
                        style="float: left"
                        >Nom d'utilisateur</label
                      >
                      <input
                        class="form-control"
                        id="inputOrgName"
                        type="text"
                        placeholder="Entrer le nom d'utilisateur"
                        v-model="nameEdited"
                      />
                    </div>
                    <!-- Form Group (location)-->
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputLocation"
                        style="float: left"
                        >Adresse E-mail</label
                      >
                      <input
                        class="form-control"
                        id="inputLocation"
                        type="text"
                        placeholder="Entrer l'adresse E-mail"
                        v-model="emailEdited"
                      />
                    </div>
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputLocation"
                        style="float: left"
                        >Mot de passe</label
                      >
                      <input
                        class="form-control"
                        id="inputLocation"
                        type="password"
                        v-model="passwordEdited"
                      />
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
                        type="button"
                        class="btn btn-primary"
                        @click="updateUser(userEdit)"
                      >
                        Modifier
                      </button>
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
      <table class="table table-striped caption-top">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nom</th>
            <th scope="col">E-mail</th>
            <th scope="col">Vérification E-mail</th>
            <th scope="col">Role</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody v-if="users.length > 0">
          <tr v-for="user in displayedUsers" :key="user.id">
            <th scope="row">{{ user.id }}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td v-if="user.role == null || user.role == 1">
              <p
                v-if="user.email_verified_at != null"
                style="color: green; font-style: italic"
              >
                vérifié le {{ formatDateTime(user.email_verified_at) }}
              </p>
              <button
                type="button"
                v-if="user.email_verified_at == null"
                class="btn btn-warning btn-sm"
                @click="verifyEmail(user.id)"
              >
                En attente
              </button>
            </td>
            <td v-else></td>
            <td>
              <button disabled class="btn btn-info btn-sm">
                {{ user.role === 2 ? "admin" : "client" }}
              </button>
            </td>
            <td>
              <a id="crudBtn" href="" class="me-4 text-info">
                <i class="fa-solid fa-eye"></i>
              </a>
              <a  id="crudBtn" @click="openEditModal(user)" class="me-4 text-warning">
                <i class="fa-solid fa-pen-to-square" ></i>
              </a>
              <a id="crudBtn" @click="deleteUser(user.id)" class="text-danger">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <p>Pas d'utilisateurs</p>
        </tbody>
      </table>
      <nav aria-label="User pagination" v-if="totalPages > 1" class="pb-1">
        <ul class="pagination justify-content-end">
          <li
            class="page-item"
            :class="{ active: page === currentPage }"
            v-for="page in totalPages"
            :key="page"
            style="cursor: pointer"
          >
            <a class="page-link shadow" @click="changePage(page)">{{ page }}</a>
          </li>
        </ul>
      </nav>
    </div>
  </SideBar>
</template>

  <script setup>
import SideBar from "../../layouts/SideBar.vue";
import {
  checkLoginStatus,
  checkLoginClient,
  checkClientVerification,
  checkClientNotVerified,
} from "../../../auth";
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";
import axios from "axios";
import SelectCountryStateCity from "../../../pages/SelectCountryStateCity.vue";

window.Swal = Swal;

let users = ref([]);
let type_industries = ref([]);
const currentPage = ref(1);
const itemsPerPage = ref(5); // Set the default number of items per page
let searchUser = ref([]);

let selectedCountry = ref("");
let selectedState = ref("");
let selectRole = ref(1);

const formatDateTime = (dateTimeString) => {
  const options = {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
  };
  return new Date(dateTimeString).toLocaleString("fr-FR", options);
};

onMounted(async () => {
  getUsers();
  get_all_types();
});


const getUsers = async () => {
  let response = await axios.get("/api/get_all_users");
  users.value = response.data.users;
  console.log("users are", JSON.stringify(users.value, null, 2));
};

const get_all_types = async () => {
  try {
    let response = await axios.get("/api/get_type_industries");
    console.log(response.data); // Log the response data
    type_industries.value = response.data.type_industries;
  } catch (error) {
    console.error(error);
  }
};

const search = async () => {
  let response = await axios.get("/api/search_user?s=" + searchUser.value);
  console.log("response", response);
  users.value = response.data.users;
  users.value = response.data.users;
};

const startForm = () => {
  if (selectRole.value == 2) {
    return true;
  } else {
    return false;
  }
};

//Page numbers
const displayedUsers = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return users.value.slice(startIndex, endIndex);
});

const totalPages = computed(() =>
  Math.ceil(users.value.length / itemsPerPage.value)
);

const changePage = (page) => {
  currentPage.value = page;
};

const handleCountryStateChanged = (stateData) => {
  // Access selectedCountry and selectedState from stateData object
  selectedCountry.value = stateData.selectedCountry;
  selectedState.value = stateData.selectedState;
};
</script>


  <script>
export default {
  components: {
    SelectCountryStateCity,
  },
  data() {
    return {
    //Create
        //Admin
      users: {},
      nameAdmin: "",
      emailAdmin: "",
      passwordAdmin: "",
      //client
      nameClient: "",
      emailClient: "",
      passwordClient: "",
      society: "",
      type_ind: "",
      responsable: "",
      N_responsable: "",
      selectedCountry: "",
      selectedState: "",
      address: "",
        //Edit
      nameEdited:"",
      emailEdited:"",
      passwordEdited: "",
      societyEdited: "",
      type_indEdited: "",
      responsableEdited: "",
      N_responsableEdited: "",
      selectedCountryEdited: "",
      selectedStateEdited: "",
      addressEdited: "",

      selectRole:"1",
      userEdit:{}
    };
  },

  created() {
    if (window.Laravel.user) {
      this.id = window.Laravel.user.id;
    }
  },

  methods: {
    async createAdmin() {
      try {
        await axios.post(`/api/users/create/admin`, {
          name: this.nameAdmin,
          email: this.emailAdmin,
          password: this.passwordAdmin,
        });
        this.nameAdmin = "";
        this.emailAdmin = "";
        this.passwordAdmin = "";
        this.$emit("user-added");

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
          title: "Utilisateur ajouté avec succés !",
        });
        // $('#addUserModal').removeClass('show');

        $('#addUserModal').modal('hide');
        $('.modal-backdrop').hide();

        this.$router.push("/users");
      } catch (error) {
        console.log(error);
      }
    },

    async createClient() {
      try {
        await axios.post(`/api/users/create/client`, {
          name: this.nameClient,
          email: this.emailClient,
          password: this.passwordClient,
          society: this.society,
          type_ind: this.type_ind,
          responsable: this.responsable,
          N_responsable: this.N_responsable,
          country: this.selectedCountry,
          city: this.selectedState,
          address: this.address,
        });
        this.nameClient = "";
        this.emailClient = "";
        this.passwordClient = "";
        this.society = "";
        this.type_ind = "";
        this.responsable = "";
        this.N_responsable = "";
        this.selectedCountry = "";
        this.selectedState = "";
        this.address = "";

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
          title: "Utilisateur ajouté avec succés !",
        });

        this.$router.push("/users");
      } catch (error) {
        console.log(error);
      }
    },


openEditModal(user){
//   console.log("userId is: " + user.id);
 console.log("password is "+user.password);
  $('#editUserModal').modal('show');
  if (user.role == 2)
  this.selectRole = '2';
  else
  this.selectRole = '1';

    this.userEdit=user;
    this.selectRole=user.role;
    this.nameEdited=user.name;
    this.emailEdited =user.email;
    this.passwordEdited = user.password;

    this.society =user.society;
    this.type_ind =user.type_ind;
    this.responsable =user.responsable;
    this.N_responsable =user.N_responsable;
    this.selectedCountry =user.country;
    this.selectedState =user.state;
    this.address =user.address;

},

updateUser(user){
    console.log("userID is: "+user.id);
    try{
    axios.put(`/api/users/edit/${user.id}`, {
        role:this.selectRole,
        name: this.nameEdited,
        email: this.emailEdited,
        password: this.passwordEdited,

        society:this.society,
        type_ind:this.type_ind,
        responsable:this.responsable,
        N_responsable:this.N_responsable,
        country:this.selectedCountry,
        city:this.selectedState,
        address:this.address,

    });
    console.log("the name i want"+this.nameEdited);
    console.log("the mail i want"+this.emailEdited);
    this.nameEdited = "";
    this.emailEdited = "";
    this.passwordEdited = "";
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
          title: "Utilisateur modifié avec succés !",
        });
        // $('#addUserModal').removeClass('show');

        $('#addUserModal').modal('hide');
        $('.modal-backdrop').hide();

        this.$router.push("/users");
    }
     catch (error) {
        console.log(error);
      }
},
    deleteUser(user_id) {
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
          if (this.id == user_id) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Il y a eu un problème!",
            });
          } else {
            axios
              .post("/api/user/delete/" + user_id)
              .then((response) => {
                this.getUsers();
                console.log(response);
              })
              .catch((errors) => {
                console.log(errors);
              });
            Swal.fire("Deleted!", "L'utilisateur a été supprimé!", "success");
          }
        }
      });
    },
    verifyEmail(user_id) {
      Swal.fire({
        title: "Valider l'E-mail ?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Non",
        confirmButtonText: "Oui",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("/api/user/verifyEmail/" + user_id)
            .then((response) => {
              this.getUsers();
              console.log(response);
            })
            .catch((errors) => {
              console.log(errors);
            });

          Swal.fire({
            title: "E-mail validé !",
            icon: "success",
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
