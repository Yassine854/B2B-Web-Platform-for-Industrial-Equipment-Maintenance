<template>
    <!-- Admin Dashboard -->
    <SideBar v-if="checkLoginAdmin()">
        <div >
            welcome to your dashboard admin
        </div>
    </SideBar>

    <!-- Client Dashboard -->
    <SideBar v-else>
        <div v-if="checkClientVerification()">
            Bienvenue dans votre dashboard
        </div>
        <div v-else>
            Veuillez valider votre adresse e-mail
        </div>
    </SideBar>
  </template>

<script setup>
import SideBar from '../components/layouts/SideBar.vue'; // Update the import statement
import { checkLoginStatus,checkLoginAdmin,checkClientVerification } from '../auth'; // Import the checkLoginStatus function
</script>

<script>
export default {
  name: "Dashboard",
  //check auth
  beforeRouteEnter(to, from, next) {
    if (checkLoginStatus()) {
      next();
    } else {
      next('/login');
    }
  },
  data() {
            return {
                role: null,
            }
        },
        created() {
            if (window.Laravel.user) {
                this.role = window.Laravel.user.role
                console.log("user's role is "+this.role);
            }
        },
        methods:{
            isAdmin() {
                return this.role === 2;
            },
        },
};
</script>
