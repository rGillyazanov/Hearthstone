<template>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Авторизация</div>

                    <div class="card-body">
                        <div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" v-model="form.email" class="form-control" id="email" />
                                <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" v-model="form.password" class="form-control" id="password" />
                                <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
                            </div>
                            <button @click.prevent="login" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                form: {
                    email: "",
                    password: ""
                },
                errors: []
            };
        },
        methods: {
            login() {
                this.$store.dispatch('login/login', this.form).then(() => {
                    this.$router.push({name: 'Home'})
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>