<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div v-for="card in cards.data" :key="card.id" class="col-4">
                                <img :src="getImageCard(card.id_card)" height="300" :alt="card.name" class="image-card-rounded">
                            </div>
                        </div>
                        <pagination :limit="2" align="center" :data="cards" @pagination-change-page="getCards"></pagination>
                    </div>
                    <div class="col-3 mt-5">
                        <cards-search-form></cards-search-form>
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
            axios.get("/api/cards").then(response => {
                this.cards = response.data.data;
            })
        },
        methods: {
            getCards(page = 1) {
                axios.get('/api/cards?page=' + page).then(response => {
                    this.cards = response.data.data;
                });
            },
            getImageCard(id) {
                return "https://art.hearthstonejson.com/v1/render/latest/ruRU/256x/" + id + ".png";
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