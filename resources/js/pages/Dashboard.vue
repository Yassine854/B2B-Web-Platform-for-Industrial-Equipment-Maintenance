<template>
<side-bar>
    welcome to your dashboard {{ name }}
</side-bar>
</template>
<script setup>
import sideBar from '../components/layouts/SideBar.vue'
console.log(name); // Check the value of the 'name' variable

</script>
