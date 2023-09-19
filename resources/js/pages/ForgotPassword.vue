<template>
    <div>
      <h1>Forgot Password</h1>
      <form @submit.prevent="sendPasswordResetEmail">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>
        <button type="submit">Send Password Reset Email</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        email: '',
      };
    },
    methods: {
      sendPasswordResetEmail() {
        // Send a POST request to your Laravel backend to initiate the password reset
        // Include the user's email in the request body
        axios.post('/api/password/reset', { email: this.email })
          .then(response => {
            // Handle the response, e.g., show a success message
          })
          .catch(error => {
          });
      },
    },
  };
  </script>
