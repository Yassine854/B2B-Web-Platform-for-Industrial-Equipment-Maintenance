<template>
  <layout ref="table">
    <p></p>
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
              v-model="searchUser"
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
              data-bs-target="#addUserModal"
            >
            <i class="fa-sharp fa-solid fa-user-plus"></i>
            </button>
          </div>

          <!-----------------------------------------------Create User------------------------------------------>

          <div class="modal fade" id="addUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                <div class="d-flex align-items-center justify-content-center mb-3">
                  <i class="fa-solid fa-user-plus fa-xl"></i>
                  <h5 class="modal-title col-11" id="addUserModalLabel">
                    Ajouter un nouvel utilisateur
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
                        required
                      >
                        <option value="1">Client</option>
                        <option value="2">Admin</option>
                      </select>
                    </div>
                  </form>

                  <!-- Client form -->
                  <form v-if="startForm() == false" @submit.prevent="createClient()">
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
                                :class="['form-control', {'is-invalid': ClientvalidationErrors.name}]"
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
                                :class="['form-control', {'is-invalid': ClientvalidationErrors.email}]"
                                  id="inputLocation"
                                  type="email"
                                  placeholder="Entrer l'adresse E-mail"
                                  v-model="emailClient"

                                />
                                <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.email" :key="index">{{ err }}<br></span>
                              </div>
                              <div class="col-md-12">
                                <label
                                  class="small mb-1"
                                  for="inputLocation"
                                  style="float: left"
                                  >Mot de passe</label
                                >
                                <input
                                :class="['form-control', {'is-invalid': ClientvalidationErrors.password}]"
                                  id="inputLocation"
                                  type="password"
                                  placeholder="Entrer le mot de passe"
                                  v-model="passwordClient"
                                />
                                <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.password" :key="index">{{ err }}<br></span>

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
                              data-bs-target="#CreateAccordion"
                              aria-expanded="true"
                              aria-controls="panelsStayOpen-collapseTwo"
                            >
                              Détails du compte
                            </button>
                          </h2>
                          <div
                            id="CreateAccordion"
                            class="accordion-collapse collapse show"
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
                                  :class="['form-control', {'is-invalid': ClientvalidationErrors.society}]"
                                    id="inputFirstName"
                                    type="text"
                                    placeholder="Entrer le nom de votre société"
                                    v-model="society"

                                  />
                                  <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.society" :key="index">{{ err }}<br></span>

                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLastName"
                                    style="float: left"
                                    >Type d'industrie</label
                                  >
                                  <select
                                  :class="['form-select', {'is-invalid': ClientvalidationErrors.type_ind}]"
                                    id="inputLastName"
                                    aria-label="Default select example"
                                    v-model="type_ind"

                                  >
                                  <option value="" disabled selected hidden>Sélectionner le type d'industrie</option>
                                    <option
                                      v-for="industrie in type_industries"
                                      :key="industrie.id"
                                      :value="industrie.id"
                                    >
                                      {{ industrie.name }}
                                    </option>
                                  </select>
                                  <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.type_ind" :key="index">{{ err }}<br></span>

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
                                  :class="['form-control', {'is-invalid': ClientvalidationErrors.responsable}]"
                                    id="inputOrgName"
                                    type="text"
                                    placeholder="Entrer le nom du répsponsable"
                                    v-model="responsable"

                                  />
                                  <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.responsable" :key="index">{{ err }}<br></span>

                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLocation"
                                    style="float: left"
                                    >Numéro du résponsable</label
                                  >
                                  <input
                                  :class="['form-control', {'is-invalid': ClientvalidationErrors.N_responsable}]"
                                    id="inputLocation"
                                    type="text"
                                    placeholder="Entrer le numéro du répsponsable"
                                    v-model="N_responsable"

                                  />
                                  <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.N_responsable" :key="index">{{ err }}<br></span>

                                </div>
                              </div>
                              <!-- Country & state Add  -->
                              <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                  <label for="country" style="float: left"
                                    >Pays</label
                                  >
                                  <select
                                :class="['form-select', {'is-invalid': ClientvalidationErrors.country}]"
                                v-model="selectedCountry"
                                @change="fireState()"
                            >
                            <option value="" selected hidden>Sélectionner le pays</option>

                                <option
                                    :value="country.id"
                                    v-for="country in countries"
                                    :key="country.id"
                                >
                                    {{ country.name }}
                                </option>
                            </select>
                                  <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.country" :key="index">{{ err }}<br></span>

                                </div>
                                <div class="col-md-6">
                                  <label for="country" style="float: left"
                                    >Gouvernorat</label
                                  >
                                  <select
                                  :class="['form-select', {'is-invalid': ClientvalidationErrors.city}]"
                                    :disabled="selectedCountry == ''"
                                    v-model="selectedState"
                                  >
                                  <option value="" selected hidden>Sélectionner le gouvernorat</option>

                                    <option
                                      :value="state.id"
                                      v-for="state in states"
                                      :key="state.id"
                                    >
                                      {{ state.name }}
                                    </option>
                                  </select>
                                  <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.city" :key="index">{{ err }}<br></span>

                                </div>
                              </div>
                              <div class="mb-3">
                                <label

                                  for="inputUsername"
                                  style="float: left"
                                  >Adresse</label
                                >
                                <textarea
                                :class="['form-control', {'is-invalid': ClientvalidationErrors.address}]"
                                  id="inputUsername"
                                  rows="4"
                                  placeholder="Entrer votre adresse"
                                  v-model="address"

                                ></textarea>
                                <span class="invalid-feedback" v-for="(err, index) in ClientvalidationErrors.address" :key="index">{{ err }}<br></span>

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
                          type="submit"
                          class="btn btn-primary"
                        >
                          Ajouter
                        </button>
                      </div>
                      <!-- ... (other fields and inputs for the client form) ... -->
                    </div>
                  </form>
                  <!-- Admin form -->
                  <form v-if="startForm() == true"  @submit.prevent="createAdmin()" >
                    <!-- Form Group (organization name)-->
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputOrgName"
                        style="float: left"
                        >Nom d'utilisateur</label
                      >
                      <input
                      :class="['form-control', {'is-invalid': AdminvalidationErrors.name}]"
                        id="inputOrgName"
                        type="text"
                        placeholder="Entrer le nom d'utilisateur"
                        v-model="nameAdmin"

                      />
                      <span class="invalid-feedback" v-for="(err, index) in AdminvalidationErrors.name" :key="index">{{ err }}<br></span>

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
                      :class="['form-control', {'is-invalid': AdminvalidationErrors.email}]"
                        id="inputLocation"
                        type="email"
                        placeholder="Entrer l'adresse E-mail"
                        v-model="emailAdmin"
                      />
                      <span class="invalid-feedback" v-for="(err, index) in AdminvalidationErrors.email" :key="index">{{ err }}<br></span>

                    </div>
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputLocation"
                        style="float: left"
                        >Mot de passe</label
                      >
                      <input
                      :class="['form-control', {'is-invalid': AdminvalidationErrors.password}]"
                        id="inputLocation"
                        type="password"
                        placeholder="Entrer le mot de passe"
                        v-model="passwordAdmin"

                      />
                      <span class="invalid-feedback" v-for="(err, index) in AdminvalidationErrors.password" :key="index">{{ err }}<br></span>

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

          <!----------------------------------------------- End Create User------------------------------------------>

          <!-----------------------------------------------Edit User------------------------------------------>

          <div class="modal fade" id="editUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-user-pen fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="addUserModalLabel">
                        Modifier l'utilisateur
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
                        v-model="selectRole" required
                      >
                        <option value="1">Client</option>
                        <option value="2">Admin</option>
                      </select>
                    </div>
                  </form>

                  <!-- Client form -->
                  <form v-if="startForm() == false" @submit.prevent="updateUser(userEdit)">
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
                                >Nom d'utilisateur</label>
                                <input
                                :class="['form-control', {'is-invalid': validationErrorsEdit.name}]"
                                  id="inputOrgName"
                                  type="text"
                                  placeholder="Entrer le nom d'utilisateur"
                                  v-model="nameEdited"

                                />
                                <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.name" :key="index">{{ err }}<br></span>

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
                                :class="['form-control', {'is-invalid': validationErrorsEdit.email}]"
                                  id="inputLocation"
                                  type="email"
                                  placeholder="Entrer l'adresse E-mail"
                                  v-model="emailEdited"

                                />
                                <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.email" :key="index">{{ err }}<br></span>

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
                              data-bs-target="#EditAccordion"
                              aria-expanded="true"
                              aria-controls="panelsStayOpen-collapseTwo"
                            >
                              Détails du compte
                            </button>
                          </h2>
                          <div
                            id="EditAccordion"
                            class="accordion-collapse collapse show"
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
                                  :class="['form-control', {'is-invalid': validationErrorsEdit.society}]"
                                    id="inputFirstName"
                                    type="text"
                                    placeholder="Entrer le nom de votre société"
                                    v-model="societyEdited"
                                  />
                                  <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.society" :key="index">{{ err }}<br></span>

                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLastName"
                                    style="float: left"
                                    >Type d'industrie</label
                                  >
                                  <select
                                  :class="['form-select', {'is-invalid': validationErrorsEdit.type_ind}]"
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
                                  <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.type_ind" :key="index">{{ err }}<br></span>

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
                                  :class="['form-control', {'is-invalid': validationErrorsEdit.responsable}]"
                                    id="inputOrgName"
                                    type="text"
                                    placeholder="Entrer le nom du répsponsable"
                                    v-model="responsableEdited"

                                  />
                                  <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.responsable" :key="index">{{ err }}<br></span>

                                </div>

                                <div class="col-md-6">
                                  <label
                                    class="small mb-1"
                                    for="inputLocation"
                                    style="float: left"
                                    >Numéro du résponsable</label
                                  >
                                  <input
                                  :class="['form-control', {'is-invalid': validationErrorsEdit.N_responsable}]"
                                    id="inputLocation"
                                    type="text"
                                    placeholder="Entrer le numéro du répsponsable"
                                    v-model="N_responsableEdited"

                                  />
                                  <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.N_responsable" :key="index">{{ err }}<br></span>

                                </div>
                              </div>

                              <!-- Country & state Add  -->
                              <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                  <label for="country" style="float: left"
                                    >Pays</label
                                  >
                                  <select
                                    id="selectCountry"
                                    :class="['form-select', {'is-invalid': validationErrorsEdit.country}]"
                                    v-model="selectedCountry"
                                    @change="fireState()"
                                  >
                                    <option
                                      :value="country.id"
                                      v-for="country in countries"
                                      :key="country.id"
                                    >
                                      {{ country.name }}
                                    </option>
                                  </select>
                                  <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.country" :key="index">{{ err }}<br></span>

                                </div>
                                <div class="col-md-6">
                                  <label for="country" style="float: left"
                                    >Gouvernorat</label
                                  >
                                  <select
                                  :class="['form-select', {'is-invalid': validationErrorsEdit.city}]"
                                    :disabled="selectedCountry == ''"
                                    v-model="selectedState"
                                  >
                                    <option hidden selected>
                                      Open this select menu
                                    </option>
                                    <option
                                      :value="state.id"
                                      v-for="state in states"
                                      :key="state.id"
                                    >
                                      {{ state.name }}
                                    </option>
                                  </select>
                                  <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.city" :key="index">{{ err }}<br></span>

                                </div>
                              </div>

                              <div class="mb-3">
                                <label
                                  class="small mb-1"
                                  for="inputUsername"
                                  style="float: left"
                                  >Adresse</label
                                >
                                <textarea
                                :class="['form-control', {'is-invalid': validationErrorsEdit.address}]"
                                  id="inputUsername"
                                  rows="4"
                                  placeholder="Entrer votre adresse"
                                  v-model="addressEdited"

                                ></textarea>
                                <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.address" :key="index">{{ err }}<br></span>

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
                          type="submit"
                          class="btn btn-primary"
                        >
                          Modifier
                        </button>
                      </div>
                      <!-- ... (other fields and inputs for the client form) ... -->
                    </div>
                  </form>
                  <!-- Admin form -->
                  <form v-if="startForm() == true" @submit.prevent="updateUser(userEdit)">
                    <!-- Form Group (organization name)-->
                    <div class="col-md-12">
                      <label
                        class="small mb-1"
                        for="inputOrgName"
                        style="float: left"
                        >Nom d'utilisateur</label
                      >
                      <input
                      :class="['form-control', {'is-invalid': validationErrorsEdit.name}]"
                        id="inputOrgName"
                        type="text"
                        placeholder="Entrer le nom d'utilisateur"
                        v-model="nameEdited"

                      />
                      <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.name" :key="index">{{ err }}<br></span>

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
                      :class="['form-control', {'is-invalid': validationErrorsEdit.email}]"
                        id="inputLocation"
                        type="email"
                        placeholder="Entrer l'adresse E-mail"
                        v-model="emailEdited"
                      />
                      <span class="invalid-feedback" v-for="(err, index) in validationErrorsEdit.email" :key="index">{{ err }}<br></span>
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

          <!--------------------- Start show client ------------------------------>

          <div class="modal fade" id="showUserModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                    <i class="fa-solid fa-user fa-xl me-2"></i>
                    <h5 class="modal-title mb-0" id="addUserModalLabel">
                        Détails du compte
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
                  <!-- First form content here (existing form) -->

                  <!-- Client form -->


                        <form>
                          <!-- Form Group (username)-->
                          <!-- <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Nom et Prénom</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Entrer votre nom et pénom">
                        </div> -->
                          <!-- Form Row-->
                          <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                              <label class="small mb-1" for="inputFirstName" style="float: left"
                                >Société</label
                              >
                              <input
                                class="form-control"
                                id="inputFirstName"
                                type="text"
                                v-model="societyEdited"
                                disabled
                              />
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                              <label class="small mb-1" for="Type_industrie" style="float: left"
                                >Type industrie</label
                              >
                              <input
                                class="form-control"
                                id="Type_industrie"
                                type="text"
                                v-model="type_indEdited"
                                disabled
                              />
                            </div>
                          </div>
                          <!-- Form Row        -->
                          <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                              <label class="small mb-1" for="Responsable" style="float: left"
                                >Responsable</label
                              >
                              <input
                                class="form-control"
                                id="Responsable"
                                type="text"
                                v-model="responsableEdited"
                                disabled
                              />
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                              <label class="small mb-1" for="N_responsableEdited" style="float: left"
                                >Numéro du Responsable</label
                              >
                              <input
                                class="form-control"
                                id="N_responsableEdited"
                                type="text"
                                v-model="N_responsableEdited"
                                disabled
                              />
                            </div>
                          </div>
                          <!-- Form Row        -->
                          <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                              <label class="small mb-1" for="Pays" style="float: left"
                                >Pays</label
                              >
                              <input
                                class="form-control"
                                id="Pays"
                                type="text"
                                v-model="SelectedCountryShow"
                                disabled
                              />
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                              <label class="small mb-1" for="Gouvernorat" style="float: left"
                                >Gouvernorat</label
                              >
                              <input
                                class="form-control"
                                id="Gouvernorat"
                                type="text"
                                v-model="SelectedStateShow"
                                disabled
                              />
                            </div>
                          </div>
                          <!-- Form Group (username)-->
                          <div class="mb-3">
                              <label class="small mb-1" for="Adresse" style="float: left"
                                >Adresse</label
                              >
                              <input
                                class="form-control"
                                id="Adresse"
                                type="textarea"
                                v-model="addressEdited"
                                disabled
                              />
                            </div>
                        </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End Show client -->
        </div>
      </div>
      <br />

      <div class="card mb-4">
        <div class="card-header d-flex align-items-center">
        <i class="fa-solid fa-users me-2"></i>
        <h5 class="mb-0">Utilisateurs</h5>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
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
                {{ user.role === 1 ? "client" : user.role === 2 ? "admin" : "user" }}

              </button>
            </td>
            <td>
              <a
                v-if="user.role == 1 || user.role == null"
                id="crudBtn"
                class="me-4 text-info"
                @click="openShowModal(user)"
              >
                <i class="fa-solid fa-eye"></i>
              </a>
              <a
                id="crudBtn"
                @click="openEditModal(user)"
                class="me-4 text-warning"
              >
                <i class="fa-solid fa-pen-to-square"></i>
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
import listCountries from "../../../json/country.json";
import listStates from "../../../json/state.json";

window.Swal = Swal;

let users = ref([]);
let type_industries = ref([]);
const currentPage = ref(1);
const itemsPerPage = ref(5); // Set the default number of items per page

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
    try {
        let response = await axios.get("/api/get_all_users");
        users.value = response.data.users;
  } catch (error) {
    console.error(error);
  }
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
</script>


  <script>
export default {
    name: "Users",
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
    searchUser:[],
      empty:null,
      countries: listCountries,
      selectedCountry: '222',
      selectedState: "",
      states: [],
      cities:listStates,
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
      address: "",
      //Edit
      nameEdited: "",
      emailEdited: "",
      societyEdited: "",
      type_indEdited: "",
      responsableEdited: "",
      N_responsableEdited: "",
      selectedCountryEdited: "",
      selectedStateEdited: "",
      addressEdited: "",

      selectRole: "1",
      userEdit: {},

      //show
      SelectedCountryShow:"",
      SelectedStateShow:"",


      AdminvalidationErrors : {},
      ClientvalidationErrors : {},
      validationErrorsEdit:{},

    };
  },

  created() {
    if (window.Laravel.user) {
      this.id = window.Laravel.user.id;
    }
    this.$nextTick(() => {
        this.fireState();
      });
  },
  mounted() {
  if (this.societyValue) {
    this.searchUser = this.societyValue;
    this.search();
  }
},

  props: {
    users: Array,
    itemsPerPage: Number,
    currentPage: Number,
    totalPages: Number,
    societyValue:String,
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
  watch: {
  societyValue(newSocietyValue) {
    if (newSocietyValue) {
     this.searchUser = newSocietyValue;
      this.search();
    }
  },
},

  methods: {

async search() {
  let response = await axios.get("/api/search_user?s=" + this.searchUser);
  console.log("response", response);
  this.users = response.data.users;
},


    selectedCountryName(countryId) {
      const country = this.countries.find(country => country.id === countryId);
      return country ? country.name : '';
    },

    selectedStateName(StateId) {
      const state = this.cities.find(state => state.id === StateId);
      return state ? state.name : '';
    },

    SelectedType_indShow(type_ind) {
        console.log(this.type_industries);
      const type = this.type_industries.find(type => type.id === type_ind);
      return type ? type.name : '';
    },

    changePage(page) {
      this.$emit("page-change", page);
    },
    fireState() {
      this.states = [];
      this.states = listStates.filter(
        (state) => state.country_id === this.selectedCountry
      );
    },
    arrayRemove(arr, value) {
      return arr.filter(function (ele) {
        return ele != value;
      });
    },

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

        $("#addUserModal").modal("hide");

        this.getUsers();
      } catch (error) {
        if (error.response.status === 400) {
          // Validation errors, set the validationErrors object
          this.AdminvalidationErrors = error.response.data.errors;
          console.log(this.AdminvalidationErrors);
        } else {
          // Handle other errors (e.g., server errors)
          this.errorMessage = "Une erreur s'est produite lors de la création du type.";
        }
      }

    },

    async createClient() {
        this.ClientvalidationErrors={};
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
        $("#addUserModal").modal("hide");

        this.getUsers();
      }catch (error) {
        if (error.response.status === 400) {
          // Validation errors, set the validationErrors object
          this.ClientvalidationErrors = error.response.data.errors;
          console.log(this.ClientvalidationErrors);
        } else {
          // Handle other errors (e.g., server errors)
          this.errorMessage = "Une erreur s'est produite lors de la création du type.";
        }
      }

    },

    openEditModal(user) {
      //   console.log("userId is: " + user.id);
      console.log("password is " + user.password);
      $("#editUserModal").modal("show");
      if (user.role == 2) this.selectRole = "2";
      else this.selectRole = "1";

      this.userEdit = user;
      this.selectRole = user.role;
      this.nameEdited = user.name;
      this.emailEdited = user.email;

      this.societyEdited = user.society;
      this.type_indEdited = user.type_ind;
      this.responsableEdited = user.responsable;
      this.N_responsableEdited = user.N_responsable;
      this.selectedCountry = user.country;

      this.selectedState = user.city;
      this.$nextTick(() => {
        this.fireState();
      });
      console.log("country=" + this.selectedCountry);
      console.log("city=" + this.selectedState);
      this.addressEdited = user.address;
    },
    openShowModal(user) {
      //   console.log("userId is: " + user.id);
      $("#showUserModal").modal("show");

      this.userEdit = user;

      this.societyEdited = user.society;
      console.log("type===="+user.type_ind);
      this.type_indEdited = this.SelectedType_indShow(user.type_ind);
      console.log(this.type_indEdited);
      this.responsableEdited = user.responsable;
      this.N_responsableEdited = user.N_responsable;
      this.SelectedCountryShow = this.selectedCountryName(user.country);
      this.SelectedStateShow = this.selectedStateName(user.city);
      console.log("country=" + this.SelectedCountryShow);
      console.log("city=" + this.SelectedStateShow);
      this.addressEdited = user.address;
    },

    async updateUser(user) {
        this.validationErrorsEdit={};
try {
 await axios.put(`/api/users/edit/${user.id}`, {
    role: this.selectRole,
    name: this.nameEdited,
    email: this.emailEdited,

    society: this.societyEdited,
    type_ind: this.type_indEdited,
    responsable: this.responsableEdited,
    N_responsable: this.N_responsableEdited,
    country: this.selectedCountry,
    city: this.selectedState,
    address: this.addressEdited,
  });
  this.userEdit = {};
  this.selectRole = "";
  this.nameEdited = "";
  this.emailEdited = "";
  this.societyEdited = "";
  this.type_indEdited = "";
  this.responsableEdited = "";
  this.N_responsableEdited = "";
  this.selectedCountry = "";
  this.selectedState = "";
  this.addressEdited = "";
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
    title: "Client modifié avec succés!",
  });
  // $('#addUserModal').removeClass('show');

  $("#editUserModal").modal("hide");

  this.getUsers();
} catch (error) {
    if (error.response.status === 400) {
          // Validation errors, set the validationErrors object
          this.validationErrorsEdit = error.response.data.errors;
          console.log(this.validationErrorsEdit);
        } else {
          // Handle other errors (e.g., server errors)
          this.errorMessage = "Une erreur s'est produite lors de la création du type.";
        }
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
          if (this.id == user_id || user_id==1) {
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
                Swal.fire("Supprimé!", "L'utilisateur a été supprimé!", "success");
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
        axios.get("/notifications/" + user_id)
             .then((response) => {
              console.log("notification sent !");
            })
            .catch((errors) => {
              console.log(errors);
            });
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
