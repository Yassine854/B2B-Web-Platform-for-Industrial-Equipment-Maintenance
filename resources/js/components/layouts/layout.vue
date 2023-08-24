<template >
    <!-- Page Wrapper -->
<body id="page-top">
<div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" >

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i ><img :src="'../storage/img/GS.png'"></i>
        </div>

        <div class="sidebar-brand-text mx-3">
    <span class="d-block font-weight-bold" style="font-size: 1.25rem;">Génerale</span>
    <span class="d-block" style="font-size: 0.48rem;">Services Industriels</span>
</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <router-link to="/dashboard" class="nav-link" >
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></router-link>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


        <!-- Nav Item - Users -->
        <li class="nav-item">
        <router-link to="/users" class="nav-link">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Utilisateurs</span></router-link>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Parc_clients -->
    <li class="nav-item">
        <router-link to="/parc_clients" class="nav-link">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Parc Clients</span></router-link>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Interventions</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <router-link to="/products"  class="nav-link">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Pompes</span></router-link>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Types</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <router-link to="types_industrie" class="collapse-item" >Types d'industries</router-link>
                <router-link to="types_product" class="collapse-item" >Types de produits</router-link>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">



    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>



            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">


                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter">3+</span>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            Notifications
                        </h6>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 12, 2019</div>
                                <span class="font-weight-bold">A new monthly report is ready to download!</span>
                            </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-donate text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 7, 2019</div>
                                $290.29 has been deposited into your account!
                            </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">December 2, 2019</div>
                                Spending Alert: We've noticed unusually high spending for your account.
                            </div>
                        </a>
                        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                    </div>
                </li>



                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600">{{ name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated--fade-in" aria-labelledby="navbarDropdown">
                        <router-link to="/profile" class="dropdown-item" >
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </router-link >
                    <div class="dropdown-divider"></div>
                    <a style="cursor: pointer" class="dropdown-item" @click="logout" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Déconnexion
                                </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->


        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div> -->
            <slot></slot>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->








    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>© Copyright 2023 - Génerale Services Industriels GSI Made with Envision Agency</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->



<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

</body>
</template>


<script>
export default {
  name: "SideBar",
  data() {
    return {
      name: null,
      role:"",
    };
  },
  created() {
    if (window.Laravel.user) {
      this.name = window.Laravel.user.name;
      this.role = window.Laravel.user.role;
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
      e.preventDefault();
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("/api/logout")
          .then((response) => {
            if (response.data.success) {
              window.location.href = "/login";
            } else {
              console.log(response);
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
};
</script>
