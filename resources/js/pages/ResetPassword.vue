<template>
    <div>
      <h1>Reset Password</h1>
      <form @submit.prevent="resetPassword">
        <label for="password">New Password:</label>
        <input type="password" id="password" v-model="password" required>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" v-model="passwordConfirmation" required>
        <button type="submit">Reset Password</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        password: '',
        passwordConfirmation: '',
      };
    },
    methods: {
     async resetPassword() {
        const token = this.$route.params.token;
        const email=this.$route.params.email;
        console.log(email);

        // Send a POST request to your Laravel backend to reset the password
        // Include the new password and confirmation along with the token
       await axios.post(`/api/password/reset/${token}/${email}`, {
          password: this.password,
          password_confirmation: this.passwordConfirmation,
          token:token,
          email:email,
        })
          .then(response => {
            // Handle the response, e.g., show a success message
          })
          .catch(error => {
            // Handle errors
          });
      },
    },
  };
  </script>
