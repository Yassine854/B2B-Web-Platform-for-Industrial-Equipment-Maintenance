<template>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Generale Services</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li id="btnHover">
                            <router-link to="/dashboard"  class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-gauge"></i> <span class="ms-1 d-none d-sm-inline" >Dashboard</span> </router-link>
                        </li>
                        <li id="btnHover">

                            <router-link to="/users" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-user"></i> <span class="ms-1 d-none d-sm-inline">Utilisateurs</span></router-link>
                        </li>
                        <li id="btnHover">
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fa-brands fa-usps"></i> <span class="ms-1 d-none d-sm-inline">Services</span></a>
                        </li>

                    </ul>
                    <hr>
                    <i class="fa-solid fa-bell" id="bell"></i>
                    <div class="dropdown pb-4" id="userDropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">
                            <span class="text-truncate d-inline-block" style="max-width: 100px;">{{ name }}</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><router-link to="/profile" class="dropdown-item" href="#">Profile</router-link></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" style="cursor: pointer;" @click="logout">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col py-3" style="background-color: lightgray;">

                <slot></slot>
            </div>
        </div>
    </div>
    </template>
    <script>
    export default {
        name: "SideBar",
        data() {
            return {
                name: null,
            }
        },
        created() {
            if (window.Laravel.user) {
                this.name = window.Laravel.user.name
            }
        },
        beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/";
            }
            next();
        },
        methods: {
            logout(e) {
                e.preventDefault()
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/logout')
                    .then(response => {
                        if(response.data.success) {
                            window.location.href = "/login"
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                })
            }
        },

    }
    </script>
<style>
#btnHover:hover{
background-color: lightgray;
}
#bell{
    position: fixed;
    left: 180px;
    bottom: 33px;
}
#btnHover:hover{
background-color: lightgray;
}
#userDropdown {
  position: fixed;
  bottom: 5px;
}

/* Adjusting the width of the dropdown menu */
.dropdown-menu {
  min-width: 200px;
}

/* Styling for the dropdown menu */
.dropdown-menu-dark {
  background-color: #343a40;
}
</style>
