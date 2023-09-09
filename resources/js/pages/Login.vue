<template>
    <div class="container">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="d-flex justify-content-center">
            <div class="col-md-8">

                <div class="d-flex justify-content-center">
                <img :src="'../storage/img/GSI-logo-PNG.png'" style="max-width:390px">
                </div>
             <br>
             <div v-if="error !== null" class="alert alert-danger" role="alert">
                    <strong>{{error}}</strong>
                </div>
                <div class="card card-default">
                    <div class="card-header"><h5>Login</h5></div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Adresse E-Mail</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email"
                                           autofocus  placeholder="Entrer votre e-mail" required>
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
                                        Login
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                    Vous n'avez pas encore de compte ?
                                    <router-link to="/register">S'inscrire</router-link>
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
                email: "",
                password: "",
                error: null
            }
        },

        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if (this.email.trim() == "" || this.password.trim() == "")
                    this.error = "Veuillez remplir à la fois les champs de l'adresse e-mail et du mot de passe.";
                else if (this.email.trim() !== "" && this.password.trim() !== "") {
                    this.$axios.get('/sanctum/csrf-cookie').then(response => {
                        this.$axios.post('api/login', {
                            email: this.email,
                            password: this.password
                        })
                        .then(response => {
                            if (response.data.success) {
                                this.$router.go('/login')
                            } else {
                                this.error = response.data.message
                            }
                        })
                        .catch(error => {
                        console.error(error);
                        this.error = "Une erreur s'est produite lors de la connexion. Veuillez vérifier votre adresse e-mail ou votre mot de passe.";
                    });
                    })
                }
                else{
                    this.error = "idk";
                }
                // this.email= "",
                // this.password= "",
                // this.error= null
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
