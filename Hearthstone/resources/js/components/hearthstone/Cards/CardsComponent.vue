<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex flex-sm-wrap-reverse">
                    <div class="col-lg-9 col-xs-12 d-flex flex-column">
                        <div class="row">
                            <div v-for="card in cards.data" :key="card.id" class="col-lg-3 col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
                                <router-link :to="{name: 'Card', params: {id: card.id}}">
                                    <img :src="setImageCard(card.id_card)" height="300" :alt="card.name" class="image-card-rounded">
                                </router-link>
                            </div>
                        </div>
                        <pagination :limit="2" align="center" :data="cards" @pagination-change-page="getCards"></pagination>
                    </div>
                    <div class="col-lg-3 col-xs-12 mt-4">
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

    export default {
        data() {
            return {
                cards: {}
            }
        },
        mounted() {
            axios.get('/api/cards').then(response => {
                this.cards = response.data.data;
            });
        },
        methods: {
            getCards(page = 1) {
                // Ссылка на следуюшую страницу, такая же как у первой, но меняется page
                axios.get(this.cards.first_page_url.match(/(.*?)page=/g) + page).then(response => {
                    this.cards = response.data.data;
                });
            },
            setImageCard(id_card) {
                return `https://art.hearthstonejson.com/v1/render/latest/ruRU/256x/${id_card}.png`;
            }
        },
        components: {
            pagination,
            cardsSearchForm: CardsSearchFormComponent
        }
    }
</script>

<style scoped>

</style>