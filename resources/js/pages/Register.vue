<template>
    <div class="container">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="d-flex justify-content-center">
            <div class="col-md-8">

                <div class="d-flex justify-content-center">
                <img :src="'../storage/img/GSI-logo-PNG.png'" style="max-width:390px">
                </div>
             <br>
             <div v-if="errors.length > 0" class="alert alert-danger" role="alert">
            <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>            </ul>
          </div>
                <div class="card card-default">
                    <div class="card-header"><h5>Inscrire un Nouvel Utilisateur</h5></div>
                    <div class="card-body">
                        <form>

                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Nom d'utilisateur</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" v-model="name" required
                                           autofocus autocomplete="off"  placeholder="Entrer votre nom">
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Adresse E-Mail</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                           autofocus autocomplete="off" placeholder="Entrer votre e-mail">
                                </div>
                            </div>
                            <br>

                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Mot de passe</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off" placeholder="Entrer votre mot de passe">
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="handleSubmit">
                                        S'inscrire
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                    Vous avez un compte ? Veuillez vous
                                    <router-link to="/login">connecter</router-link>
                                    </small>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "",
                email: "",
                password: "",
                errors: []
            }
        },

        methods: {
  async handleSubmit(e) {
    e.preventDefault();
    this.errors = []; // Reset errors array

    if (this.name.trim() === "") {
      this.errors.push("Veuillez remplir le champ du nom.");
    }
    if (this.email.trim() === "") {
      this.errors.push("Veuillez remplir le champ d'adresse e-mail.");
    }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(this.email)) {
      this.errors.push("L'adresse e-mail n'est pas valide.");
    }
    if (this.password.trim() === "") {
      this.errors.push("Veuillez remplir le champ du mot de passe.");
    }
    if (this.password.trim().length < 8) {
    this.errors.push("Le mot de passe doit contenir au moins 8 caractères.");
  }
    if (this.password.length >=8) {
      this.$axios.get('/sanctum/csrf-cookie').then(async (response) => {
        try {
          // Check email uniqueness
          const emailCheckResponse = await this.$axios.post('/api/check-email', {
            email: this.email
          });

          if (!emailCheckResponse.data.isUnique) {
            this.errors.push("L'adresse e-mail est déjà utilisée.");
            return;
          }

          // Continue with registration if email is unique
          const registrationResponse = await this.$axios.post('api/register', {
            name: this.name,
            email: this.email,
            password: this.password
          });

          if (registrationResponse.data.success) {
            window.location.href = "/login";
          } else {
            this.errors.push(registrationResponse.data.message);
          }
        } catch (error) {
          console.error(error);
          this.errors.push("Une erreur s'est produite lors de l'inscription. Veuillez réessayer plus tard.");
        }
      });
    }
  }
},
        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedin) {
                return next('dashboard');
            }
            next();
        }
    }
</script>
