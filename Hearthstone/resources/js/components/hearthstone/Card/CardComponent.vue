<template>
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-center" v-if="loading">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div v-if="error">
                <h1>404</h1>
            </div>
            <div class="col-12" v-if="card">
                Name: {{ card.name }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CardComponent",
        data() {
            return {
                card: null,
                id: this.$route.params['id'],
                error: null,
                loading: null
            }
        },
        watch: {
            $route (toRoute) {
                this.id = toRoute.params['id']
            }
        },
        created() {
            this.error = this.card = null;
            this.loading = true;

            axios.get('/api/card/' + this.id).then(response => {
                this.error = this.loading = false;
                this.card = response.data.data;
            }).catch(error => {
                if (error.response.status === 404) {
                    this.error = true;
                }
            });
        }
    }
</script>

<style scoped>

</style>