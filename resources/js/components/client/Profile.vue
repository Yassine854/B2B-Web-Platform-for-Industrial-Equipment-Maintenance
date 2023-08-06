<template>
    <SideBar>
        <div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="">Profile</a>
        <a class="nav-link" href="">Paramétres</a>
    </nav>
    <hr class="mt-0 mb-4">
    <div class="row">

        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Détails du compte</div>
                <div class="card-body">
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
                                <label class="small mb-1" for="inputFirstName">Société</label>
                                <input class="form-control" id="inputFirstName" type="text" placeholder="Entrer le nom de votre société" >
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Type industrie</label>
                                <select class="form-select" id="inputLastName" aria-label="Default select example">
                                <option ></option>
                                </select>
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName" >Résponsable</label>
                                <input class="form-control" id="inputOrgName" type="text" placeholder="Entrer le nom du répsponsable" >
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Numéro du résponsable</label>
                                <input class="form-control" id="inputLocation" type="text" placeholder="Entrer le numéro du répsponsable" >
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Pays</label>
                                <input class="form-control" id="inputOrgName" type="text" >
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Gouvernorat</label>
                                <input class="form-control" id="inputLocation" type="text"  >
                            </div>
                        </div>
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Adresse</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Entrer votre adresse" >
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="button">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
      </SideBar>
</template>

<script setup>
import SideBar from '../../components/layouts/SideBar.vue';
import { checkLoginStatus,checkLoginAdmin,checkClientVerification } from '../../auth';
</script>

<script>

</script>

<style>

.img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
}
.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
}
.card .card-header {
    font-weight: 500;
}
.card-header:first-child {
    border-radius: 0.35rem 0.35rem 0 0;
}
.card-header {
    padding: 1rem 1.35rem;
    margin-bottom: 0;
    background-color: rgba(33, 40, 50, 0.03);
    border-bottom: 1px solid rgba(33, 40, 50, 0.125);
}
.form-control, .dataTable-input {
    display: block;
    width: 100%;
    padding: 0.875rem 1.125rem;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1;
    color: #69707a;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #c5ccd6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.35rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.nav-borders .nav-link.active {
    color: #0061f2;
    border-bottom-color: #0061f2;
}
.nav-borders .nav-link {
    color: #69707a;
    border-bottom-width: 0.125rem;
    border-bottom-style: solid;
    border-bottom-color: transparent;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0;
    padding-right: 0;
    margin-left: 1rem;
    margin-right: 1rem;
}
</style>
