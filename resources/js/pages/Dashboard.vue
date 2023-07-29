<template>
    <SideBar>
      welcome to your dashboard
    </SideBar>
  </template>
<script setup>
import SideBar from '../components/layouts/SideBar.vue'; // Update the import statement
import { checkLoginStatus } from '../auth'; // Import the checkLoginStatus function
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
  }
};
</script>
