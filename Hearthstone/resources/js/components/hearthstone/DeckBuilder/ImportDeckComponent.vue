<template>
    <div class="col-12">
        <div class="row mt-5 justify-content-center">
            <div class="col-6 my-1">
                <input type="text" class="form-control" v-model="code" placeholder="Вставьте код колоды">
            </div>
            <div class="my-1">
                <router-link class="btn btn-primary" :to="{name: 'Deck', params: {code: code}}">
                    Импорт
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ImportDeckComponent",
        data() {
            return {
                code: ''
            }
        }
    }
</script>

<style scoped>

</style>