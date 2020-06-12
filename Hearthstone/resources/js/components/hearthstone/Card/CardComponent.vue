<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                Name: {{ name }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CardComponent",
        data() {
            return {
                name: '',
                id: this.$route.params['id']
            }
        },
        watch: {
            $route (toRoute, fromRoute) {
                this.id = toRoute.params['id']
            }
        },
        mounted() {
            axios.get('/api/card/' + this.id).then(response => {
                this.name = response.data.data.name;
            }).catch(error => {
                console.log(error.response.data);
            });
        }
    }
</script>

<style scoped>

</style>