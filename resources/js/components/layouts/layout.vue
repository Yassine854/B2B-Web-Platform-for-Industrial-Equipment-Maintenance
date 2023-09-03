<template >
    <!-- Admin SideBar -->
  <!-- Page Wrapper -->
  <body id="page-top" v-if="checkLoginAdmin()">
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="index.html"
        >
          <div class="sidebar-brand-icon">
            <i><img :src="'../storage/img/GS.png'" /></i>
          </div>

          <div class="sidebar-brand-text mx-3">
            <span class="d-block font-weight-bold" style="font-size: 1.25rem"
              >Génerale</span
            >
            <span class="d-block" style="font-size: 0.48rem"
              >Services Industriels</span
            >
          </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item" :class="{ 'active': $route.name === 'dashboard' || !$route.name }">
        <a :href="$router.resolve({name: 'dashboard'}).href" class="nav-link">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Nav Item - Users -->
        <li class="nav-item" :class="{ 'active': $route.name === 'users' }">
          <a :href="$router.resolve({name: 'users'}).href" class="nav-link">
            <i class="fa-solid fa-users"></i>
            <span>Utilisateurs</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Nav Item - Parc_clients -->
        <li class="nav-item" :class="{ 'active': $route.name === 'parc_clients'|| $route.name === 'parc' }">
          <a :href="$router.resolve({name: 'parc_clients'}).href" class="nav-link" >
            <i class="fa-solid fa-people-group"></i>
            <span>Parc Clients</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Nav Item - Users -->
        <li class="nav-item" :class="{ 'active': $route.name === 'interventions' }">
          <a :href="$router.resolve({name: 'interventions'}).href" class="nav-link">
            <i class="fa-brands fa-servicestack"></i>
            <span>Interventions</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Nav Item - Users -->
        <li class="nav-item" :class="{ 'active': $route.name === 'products' }">
          <a :href="$router.resolve({name: 'products'}).href" class="nav-link">
            <i class="fa-brands fa-product-hunt"></i>
            <span>Pompes</span></a
          >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item" :class="{ 'active': $route.name === 'types_industrie' || $route.name === 'types_product' }">
  <a
    class="nav-link collapsed"
    href="#"
    data-toggle="collapse"
    data-target="#collapseTwo"
    aria-expanded="true"
    aria-controls="collapseTwo"
  >
    <i class="fa-solid fa-ticket"></i>
    <span>Types</span>
  </a>
  <div
    id="collapseTwo"
    class="collapse"
    aria-labelledby="headingTwo"
    data-parent="#accordionSidebar"
  >
    <div class="bg-white py-2 collapse-inner rounded">
      <a :href="$router.resolve({name: 'types_industrie'}).href" class="collapse-item">
        Types d'industries
      </a>
      <a :href="$router.resolve({name: 'types_product'}).href" class="collapse-item">
        Types de produits
      </a>
    </div>
  </div>
</li>

        <!-- Divider -->
        <hr class="sidebar-divider" />

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
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
          >
            <!-- Sidebar Toggle (Topbar) -->
            <button
              id="sidebarToggleTop"
              class="btn btn-link d-md-none rounded-circle mr-3"
            >
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - Alerts -->
              <li class="nav-item dropdown no-arrow mx-1">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="alertsDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="fas fa-bell fa-fw"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter">{{
                    notifications.length
                  }}</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div
                  class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="alertsDropdown"
                >
                  <h6 class="dropdown-header">Notifications</h6>

                  <span
                    v-if="notifications.length === 0"
                    class="font-weight-bold ml-4"
                    >Acune Notification disponible.</span
                  >
                  <a
                    class="dropdown-item d-flex align-items-center"
                    href="#"
                    v-for="notification in notifications"
                    :key="notification.id"
                  >
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-bell fa-fw text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">
                        Il y a {{ timeSince(notification.created_at) }}
                      </div>
                      <span class="font-weight-bold">{{
                        notification.data.message
                      }}</span>
                    </div>
                  </a>

                  <a
                    class="dropdown-item text-center small text-gray-500"
                    href="#"
                    >Show All Alerts</a
                  >
                </div>
              </li>

              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600">{{
                    name
                  }}</span>
                  <img
                    class="img-profile rounded-circle"
                    :src="`/storage/img/profile.png`"
                />
                </a>
                <div
                  class="dropdown-menu dropdown-menu-right animated--fade-in"
                  aria-labelledby="navbarDropdown"
                >
                  <a :href="$router.resolve({name: 'profile'}).href" class="dropdown-item">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                  </a>
                  <div class="dropdown-divider"></div>
                  <a
                    style="cursor: pointer"
                    class="dropdown-item"
                    @click="logout"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
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
              <span
                >© Copyright 2023 - Génerale Services Industriels GSI Made with
                Envision Agency</span
              >
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

  <!--End Admin SideBar -->









  <!-- Client SideBar -->
  <body id="page-top" v-else>
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a
          class="sidebar-brand d-flex align-items-center justify-content-center"
          href="index.html"
        >
          <div class="sidebar-brand-icon">
            <i><img :src="'../storage/img/GS.png'" /></i>
          </div>

          <div class="sidebar-brand-text mx-3">
            <span class="d-block font-weight-bold" style="font-size: 1.25rem"
              >Génerale</span
            >
            <span class="d-block" style="font-size: 0.48rem"
              >Services Industriels</span
            >
          </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a :href="$router.resolve({name: 'dashboard'}).href" class="nav-link">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a
          >
        </li>




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
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
          >
            <!-- Sidebar Toggle (Topbar) -->
            <button
              id="sidebarToggleTop"
              class="btn btn-link d-md-none rounded-circle mr-3"
            >
              <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - Alerts -->
              <li class="nav-item dropdown no-arrow mx-1">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="alertsDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="fas fa-bell fa-fw"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter">{{
                    notifications.length
                  }}</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div
                  class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="alertsDropdown"
                >
                  <h6 class="dropdown-header">Notifications</h6>

                  <span
                    v-if="notifications.length === 0"
                    class="font-weight-bold ml-4"
                    >Acune Notification disponible.</span
                  >
                  <a
                    class="dropdown-item d-flex align-items-center"
                    href="#"
                    v-for="notification in notifications"
                    :key="notification.id"
                  >
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-bell fa-fw text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">
                        Il y a {{ timeSince(notification.created_at) }}
                      </div>
                      <span class="font-weight-bold">{{
                        notification.data.message
                      }}</span>
                    </div>
                  </a>

                  <a
                    class="dropdown-item text-center small text-gray-500"
                    href="#"
                    >Show All Alerts</a
                  >
                </div>
              </li>

              <div class="topbar-divider d-none d-sm-block"></div>

              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600">{{
                    name
                  }}</span>
                </a>
                <div
                  class="dropdown-menu dropdown-menu-right animated--fade-in"
                  aria-labelledby="navbarDropdown"
                >
                  <a :href="$router.resolve({name: 'profile'}).href" class="dropdown-item">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                  </a>
                  <div class="dropdown-divider"></div>
                  <a
                    style="cursor: pointer"
                    class="dropdown-item"
                    @click="logout"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
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
              <span
                >© Copyright 2023 - Génerale Services Industriels GSI Made with
                Envision Agency</span
              >
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
  <!-- End Client Sidebar -->


</template>

<script setup>
import {
  checkLoginStatus,
  checkLoginAdmin,
  checkClientVerification,
} from "../../auth";
// Function to calculate time since a timestamp
const timeSince = (timestamp) => {
  const now = new Date();
  const createdAt = new Date(timestamp);
  const timeDiff = now - createdAt;

  const seconds = Math.floor(timeDiff / 1000);
  if (seconds < 60) {
    return `${seconds} secondes`;
  }

  const minutes = Math.floor(timeDiff / 1000 / 60);
  if (minutes < 60) {
    return `${minutes} minute(s)`;
  }

  const hours = Math.floor(timeDiff / 1000 / 3600);
  if (hours < 24) {
    return `${hours} heure(s)`;
  }

  const days = Math.floor(timeDiff / 1000 / 3600 / 24);
  return `${days} jour(s)`;

};
</script>
<script>
export default {
  name: "SideBar",
  data() {
    return {
      name: null,
      role: "",
      notifications: [],
    };
  },
  mounted() {
    this.get_all_notifications();
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

    async get_all_notifications() {
      try {
        const response = await axios.get("/api/get_all_notifications");
        this.notifications = response.data.notifications;
        console.log(
          "notifications are",
          JSON.stringify(this.notifications, null, 2)
        );
      } catch (error) {
        console.error("Error fetching notifications:", error);
      }
    },
  },
};
</script>
