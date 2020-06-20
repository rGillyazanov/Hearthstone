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
                        <h1 class="text-center mx-auto pb-lg-5 mb-lg-0 font-weight-lighter">Выберите героя</h1>
                        <div class="col-lg-12 col-12 mx-auto">
                            <div class="row d-flex justify-content-center heroes">
                                <template v-for="hero in heroes">
                                    <div class="col-md-2 col-sm-12">
                                        <router-link :to="{name: 'CardsForDeck', params: {id: hero.id}}">
                                            <img class="img-fluid" :src="'/images/hearthstone/heroes/' + hero.name + '_static.png'" :alt="trans.get('heroes.' + hero.name)">
                                        </router-link>
                                    </div>
                                </template>
                            </div>
                        </div>
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
    export default {
        name: "ChoiceHeroesComponent",
        data() {
            return {
                heroes: null,
                error: null,
                loading: null,
            }
        },
        methods: {
            hoverImages() {
                $('.heroes div > a > img').hover(function () {
                    $(this).attr('src', (i, val) => {
                        return val.indexOf('static') !== -1 ? val.replace("static", "hover") : val.replace("hover", "static");
                    });
                });
            },
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
        updated() {
            this.$nextTick(() => {
                this.hoverImages();
            })
        },
        mounted() {
            this.getHeroes();
        }
    }
</script>

<style scoped>
    .heroes div {
        display: flex;
        justify-content: center;
        cursor: pointer;
    }
</style>