<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex flex-sm-wrap-reverse">
                    <div class="col-lg-9 col-xs-12" v-if="loading">
                        <div class="row h-100 d-flex align-items-center justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xs-12 d-flex justify-content-center align-items-center" v-if="error">
                        <h1 class="alert alert-danger">Ошибка при получении карт</h1>
                    </div>
                    <div class="col-lg-9 col-xs-12 d-flex flex-column" v-if="cards && !loading">
                        <div class="col-12 d-flex justify-content-center align-items-center" v-if="!isFind">
                            <h1 class="alert alert-danger">Карт не найдено</h1>
                        </div>
                        <div class="row">
                            <div v-for="card in cards.data" :key="card.id" class="col-lg-3 col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
                                <router-link :to="{name: 'Card', params: {id: card.id}}">
                                    <img :src="setImageCard(card.id_card)" height="300" :alt="card.name" class="image-card-rounded">
                                </router-link>
                            </div>
                        </div>
                        <pagination :limit="2" align="center" :data="cards" @pagination-change-page="getCards"></pagination>
                    </div>
                    <div class="col-lg-3 col-xs-12 mt-4 mb-2">
                        <cards-search-form @getSearchResult="cards = $event.data"></cards-search-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from "laravel-vue-pagination";
    import CardsSearchFormComponent from "./CardsSearchFormComponent";
    import image from "../../../mixins/cards/image";

    export default {
        data() {
            return {
                cards: null,
                error: null,
                loading: null,
                isFind: null
            }
        },
        mounted() {
            this.error = this.cards = null;
            this.loading = true;
            axios.get('/api/cards').then(response => {
                this.cards = response.data.data;
                this.loading = this.error = false;
            }).catch(error => {
                this.error = true;
                this.loading = false;
            });
        },
        methods: {
            getCards(page = 1) {
                this.error = null;
                this.loading = true;
                // Ссылка на следуюшую страницу, такая же как у первой, но меняется page
                axios.get(this.cards.first_page_url.match(/(.*?)page=/g) + page).then(response => {
                    this.cards = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            }
        },
        updated() {
            this.$nextTick(() => {
                if (!this.loading)
                    this.isFind = this.cards.data.length !== 0;
            })
        },
        mixins: [image],
        components: {
            pagination,
            cardsSearchForm: CardsSearchFormComponent
        }
    }
</script>

<style scoped>

</style>