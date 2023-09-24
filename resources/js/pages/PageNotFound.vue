<template>
    <layout v-if="checkLoginStatus()">
  <div class="container-fluid">

<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page Not Found</p>
    <a :href="$router.resolve({ name: 'dashboard' }).href">&larr; Retour au Dashboard</a>
</div>

</div>
</layout>


<!-- 404 Error Text -->
<body v-if="!checkLoginStatus()" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <div class="container-fluid">
    <div class="d-flex flex-column justify-content-center align-items-center">
      <div class="error" data-text="404">404</div>
      <p class="lead text-gray-800 mb-5">Page Not Found</p>
      <a :href="$router.resolve({ name: 'login' }).href">&larr; Retour à la page de connexion</a>
    </div>
  </div>
</body>



</template>

<script setup>
import layout from "../components/layouts/layout.vue";
import {
  checkLoginStatus,
  checkLoginAdmin,
  checkClientVerification,
} from "../auth";
</script>
<script>
export default {

}
</script>

<style>

</style>
