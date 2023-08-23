<template>
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Navbar brand -->
        <i ><img :src="'../storage/img/GSI-logo-PNG.png'" style="width:200px;background-color: white;"></i>


        <!-- Icons -->

        <ul class="navbar-nav d-flex flex-row me-1">

            <!-- Notifications -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell text-white"></i>
                <span class="badge rounded-pill badge-notification bg-danger">{{ notifications.length }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-lg-end notifications-menu" aria-labelledby="navbarDarkDropdownMenuLink">
        <p v-if="notifications.length === 0" class="no-notifications-text">Aucune notification disponible.</p>
      <li v-for="notification in notifications" :key="notification.id" class="notification-item">
        <a @click="showSociety(notification.data.name)" class="notification-link" href="#">
          <span class="notification-title">La société <b>{{ notification.data.name }}</b> a demandé la vérification de son adresse e-mail.</span>
        </a>
        <p class="notification-time">Il y a {{ timeSince(notification.created_at) }}</p>
    </li>
    </ul>
        </li>




            <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ name }}
          </a>
          <ul  class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDarkDropdownMenuLink">
            <li><router-link to="/profile" class="dropdown-item" href="#">Profile</router-link></li>
            <li ><a @click="logout" class="dropdown-item" href="#">Déconnexion</a></li>
          </ul>
        </li>

        </ul>
    </div>
</nav>
</template>

<script setup>

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
import users from '../admin/users.vue'
export default {
  name: "SideBar",
  data() {
    return {
      name: null,
      role:"",
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
                const response = await axios.get('/api/get_all_notifications');
                this.notifications = response.data.notifications;
                console.log("notifications are", JSON.stringify(this.notifications, null, 2));
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        },

    async showSociety(name) {
  try {
    const response = await axios.get("/api/showSociety", {name: name });
    console.log("response", response);
    this.$router.push("/users");

  } catch (error) {
    console.error("Error fetching data:", error);
  }
}


  },
};
</script>

<style>
#navbarDropdownMenuLink::after {
        display: none !important;
    }

    .notifications-menu {
  max-width: 300px;
  padding: 10px;
  border: 1px solid #ccc;
  background-color: #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.notification-item {
  padding: 5px;
  border-bottom: 1px solid #ddd;
}

.notification-link {
  text-decoration: none;
  color: #333;
  display: block;
}

.notification-time {
  margin-top: 5px;
  color: #999;
  font-size: 14px;
}
</style>
