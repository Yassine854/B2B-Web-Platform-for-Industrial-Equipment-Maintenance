<template>
  <layout>
    <div class="container-xl px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Profile</h1>
            </div>

      <div class="row">
        <div class="col-xl-12">
          <!-- Account details card-->
          <div class="card mb-4">
            <div class="card-header">
              <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation" v-if="!isAdmin()">
                  <button
                    class="nav-link active"
                    id="pills-home-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-home"
                    type="button"
                    role="tab"
                    aria-controls="pills-home"
                    aria-selected="true"
                  >
                    Détails du compte
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="pills-profile-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-profile"
                    type="button"
                    role="tab"
                    aria-controls="pills-profile"
                    aria-selected="true"
                    v-if="isAdmin()"
                  >
                    Sécurité
                  </button>
                  <button
                    class="nav-link"
                    id="pills-profile-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-profile"
                    type="button"
                    role="tab"
                    aria-controls="pills-profile"
                    aria-selected="false"
                    v-else
                  >
                    Sécurité
                  </button>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="pills-tabContent">
                <div
                  class="tab-pane fade show active"
                  id="pills-home"
                  role="tabpanel"
                  aria-labelledby="pills-home-tab"
                  v-if="!isAdmin()"
                >
                  <form @submit.prevent="updateClientDetails(user)">
                    <!-- Form Group (username)-->
                    <!-- <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Nom et Prénom</label>
                                <input class="form-control" id="inputUsername" type="text" placeholder="Entrer votre nom et pénom">
                            </div> -->
                    <!-- Form Row-->
                    <div class="row gx-3 mb-3">
                      <!-- Form Group (first name)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="inputFirstName"
                          >Société</label
                        >
                        <input
                          class="form-control"
                          id="inputFirstName"
                          type="text"
                          placeholder="Entrer le nom de votre société"
                          v-model="society"
                          required
                        />
                      </div>
                      <!-- Form Group (last name)-->
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
                          required
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
                    <!-- Form Row        -->
                    <div class="row gx-3 mb-3">
                      <!-- Form Group (organization name)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="inputOrgName"
                          >Résponsable</label
                        >
                        <input
                          class="form-control"
                          id="inputOrgName"
                          type="text"
                          placeholder="Entrer le nom du répsponsable"
                          v-model="responsable"
                          required
                        />
                      </div>
                      <!-- Form Group (location)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="inputLocation"
                          >Numéro du résponsable</label
                        >
                        <input
                          class="form-control"
                          id="inputLocation"
                          type="text"
                          placeholder="Entrer le numéro du répsponsable"
                          v-model="N_responsable"
                          required
                        />
                      </div>
                    </div>

                    <!-- Country & state Add  -->
                    <div class="row gx-3 mb-3">
                      <div class="col-md-6">
                        <label for="country" style="float: left">Pays</label>
                        <select
                          class="form-select"
                          v-model="selectedCountry"
                          @change="fireState()"
                          required
                        >
                          <option selected hidden>Open this select menu</option>
                          <option
                            :value="country.id"
                            v-for="country in countries"
                            :key="country.id"
                          >
                            {{ country.name }}
                          </option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="country" style="float: left"
                          >Gouvernorat</label
                        >
                        <select
                          class="form-select"
                          :disabled="selectedCountry == ''"
                          v-model="selectedState"
                          required
                        >
                          <option hidden selected>Open this select menu</option>
                          <option
                            :value="state.id"
                            v-for="state in states"
                            :key="state.id"
                          >
                            {{ state.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <!-- Form Group (username)-->
                    <div class="mb-3">
                      <label class="small mb-1" for="inputUsername"
                        >Adresse</label
                      >
                      <textarea
                        class="form-control"
                        id="inputUsername"
                        rows="4"
                        placeholder="Entrer votre adresse"
                        v-model="address"
                        required
                      ></textarea>
                    </div>
                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">
                      Modifier
                    </button>
                  </form>
                </div>
                <div
                  class="tab-pane fade show active"
                  id="pills-profile"
                  role="tabpanel"
                  aria-labelledby="pills-profile-tab"
                  v-if="isAdmin()"
                >
                  <form @submit.prevent="updatePassword(user)">
                    <div class="mb-3">
                      <label class="small mb-1" for="email"
                        >Adresse Email</label
                      >
                      <input
                        class="form-control"
                        id="email"
                        rows="4"
                        v-model="email"
                        disabled
                      />
                    </div>

                    <div class="mb-3">
                      <label class="small mb-1" for="old_password"
                        >Mot de passe actuel</label
                      >
                      <input
                        type="password"
                        class="form-control"
                        id="old_password"
                        rows="4"
                        placeholder="Mot de passe actuel"
                        v-model="old_password"
                        required
                      />
                    </div>

                    <div class="row gx-3 mb-3">
                      <!-- Form Group (organization name)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="new_password"
                          >Nouveau mot de passe</label
                        >
                        <input
                          class="form-control"
                          id="new_password"
                          type="password"
                          placeholder="Nouveau mot de passe"
                          v-model="new_password"
                          required
                        />
                      </div>
                      <!-- Form Group (location)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="password_confirmation"
                          >Confirmez votre nouveau mot de passe</label
                        >
                        <input
                          class="form-control"
                          id="password_confirmation"
                          type="password"
                          placeholder="Confirmez votre nouveau mot de passe"
                          v-model="password_confirmation"
                          required
                        />
                      </div>
                    </div>

                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">
                      Modifier
                    </button>
                  </form>
                </div>



                <div
                  class="tab-pane fade "
                  id="pills-profile"
                  role="tabpanel"
                  aria-labelledby="pills-profile-tab"
                  v-else
                >
                  <form @submit.prevent="updatePassword(user)">
                    <div class="mb-3">
                      <label class="small mb-1" for="email"
                        >Adresse Email</label
                      >
                      <input
                        class="form-control"
                        id="email"
                        rows="4"
                        v-model="email"
                        disabled
                      />
                    </div>

                    <div class="mb-3">
                      <label class="small mb-1" for="old_password"
                        >Mot de passe actuel</label
                      >
                      <input
                        type="password"
                        class="form-control"
                        id="old_password"
                        rows="4"
                        placeholder="Mot de passe actuel"
                        v-model="old_password"
                        required
                      />
                    </div>

                    <div class="row gx-3 mb-3">
                      <!-- Form Group (organization name)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="new_password"
                          >Nouveau mot de passe</label
                        >
                        <input
                          class="form-control"
                          id="new_password"
                          type="password"
                          placeholder="Nouveau mot de passe"
                          v-model="new_password"
                          required
                        />
                      </div>
                      <!-- Form Group (location)-->
                      <div class="col-md-6">
                        <label class="small mb-1" for="password_confirmation"
                          >Confirmez votre nouveau mot de passe</label
                        >
                        <input
                          class="form-control"
                          id="password_confirmation"
                          type="password"
                          placeholder="Confirmez votre nouveau mot de passe"
                          v-model="password_confirmation"
                          required
                        />
                      </div>
                    </div>

                    <!-- Save changes button-->
                    <button class="btn btn-primary" type="submit">
                      Modifier
                    </button>
                  </form>
                </div>



              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</layout>
</template>

<script setup>
import layout from "../layouts/layout.vue";
import { onMounted, ref, computed } from "vue";
import {
  checkLoginStatus,
  checkLoginAdmin,
  checkClientVerification,
} from "../../auth";
import listCountries from "../../../json/country.json";
import listStates from "../../../json/state.json";
import Swal from "sweetalert2";

let type_industries = ref([]);

onMounted(async () => {
  get_all_types();
});

const get_all_types = async () => {
  try {
    let response = await axios.get("/api/get_type_industries");
    console.log(response.data); // Log the response data
    type_industries.value = response.data.type_industries;
  } catch (error) {
    console.error(error);
  }
};
</script>

<script>
export default {
  name: "Profile",
  //check auth
  beforeRouteEnter(to, from, next) {
    if (checkLoginStatus()) {
      next();
    } else {
      next("/login");
    }
  },

  created() {
    if (window.Laravel.user) {
      this.user = window.Laravel.user;
      this.email = window.Laravel.user.email;
      this.password = window.Laravel.user.password;
      this.role = window.Laravel.user.role;
      this.id = window.Laravel.user.id;
      //Client
      this.society = window.Laravel.user.society;
      this.type_ind = window.Laravel.user.type_ind;
      this.responsable = window.Laravel.user.responsable;
      this.N_responsable = window.Laravel.user.N_responsable;
      this.selectedCountry = window.Laravel.user.country;
      this.selectedState = window.Laravel.user.city;
      this.$nextTick(() => {
        this.fireState();
      });
      this.address = window.Laravel.user.address;
      console.log("user's role is " + this.role);
      console.log("user's id is " + this.id);
      console.log("password " + this.old_password);
    }
  },

  data() {
    return {
      formSubmitted: false,
      user: {},
      role: null,
      id: "",
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      society: "",
      type_ind: "",
      responsable: "",
      N_responsable: "",
      countries: listCountries,
      selectedCountry: "",
      selectedState: "",
      states: [],
      address: "",
      password: "",
      old_password: "",
      new_password: "",
      password_confirmation: "",
    };
  },

  methods: {
    isAdmin() {
      return this.role === 2;
    },
    fireState() {
      this.states = [];
      this.states = listStates.filter(
        (state) => state.country_id === this.selectedCountry
      );
    },
    updateClientDetails(user) {
      try {
        axios.put(`/api/users/updateClientDetails/${user.id}`, {
          society: this.society,
          type_ind: this.type_ind,
          responsable: this.responsable,
          N_responsable: this.N_responsable,
          country: this.selectedCountry,
          city: this.selectedState,
          address: this.address,
        });

        this.$router.push("/profile");
        // window.location.reload();

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
          title:
            " Les informations du profil ont été mises à jour avec succès!",
        });
      } catch (error) {
        console.log(error);
      }
    },

    async updatePassword(user) {
      try {
        // Perform an API call to check if the old password is correct
        const response = await this.$axios.post(
          `/api/user/verifyOldPassword/${user.id}`,
          {
            old_password: this.old_password,
          }
        );

        if (response.data.success) {
          console.log("Old password is correct.");
          if (this.new_password == this.password_confirmation) {
            try {
              axios.put(`/api/user/updatePassword/${user.id}`, {
                new_password: this.new_password,
              });
              this.old_password = "";
              this.new_password = "";
              this.password_confirmation = "";

              // this.$router.push("/profile");
              // window.location.reload();

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
                title: " Mot de passe mis à jour avec succès!",
              });
            } catch (error) {
              console.log("rewrite password");
            }
          }
        } else {
          console.log("NO  Old password is incorrect.");
        }
      } catch (error) {
        console.error(error);
        this.error = "Mot de passe incorrect.";
      }
    },
  },
};
</script>

<style>
</style>
