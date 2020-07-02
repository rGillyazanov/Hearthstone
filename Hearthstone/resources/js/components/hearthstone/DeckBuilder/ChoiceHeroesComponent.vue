<template>
    <div class="container">
        <div class="row" style="height: calc(100vh - 66px)">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <div class="row">
                    <div class="col-lg-9 col-xs-12" v-if="loading">
                        <div class="row h-100 d-flex align-items-center justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <template v-if="heroes && !loading">
                        <import-deck-component></import-deck-component>
                        <h1 class="text-center mt-3 mx-auto pb-lg-5 mb-lg-0 font-weight-lighter">Или выберите героя</h1>
                        <show-heroes-component :heroes="heroes"></show-heroes-component>
                    </template>
                    <div class="col-lg-9 col-xs-12 d-flex justify-content-center align-items-center" v-if="error">
                        <h1 class="alert alert-danger">Ошибка обновите страницу</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ImportDeckComponent from "./ImportDeckComponent";
    import ShowHeroesComponent from "./ShowHeroesComponent";
    export default {
        name: "ChoiceHeroesComponent",
        components: {ShowHeroesComponent, ImportDeckComponent},
        data() {
            return {
                heroes: null,
                error: null,
                loading: null,
            }
        },
        methods: {
            getHeroes() {
                this.error = this.heroes = null;
                this.loading = true;
                axios.get('/api/heroes').then(response => {
                    this.heroes = response.data.data;
                    this.heroes = this.heroes?.filter(item => item.name !== 'NEUTRAL')
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            }
        },
        mounted() {
            this.getHeroes();
        }
    }
</script>

<style scoped>

</style>