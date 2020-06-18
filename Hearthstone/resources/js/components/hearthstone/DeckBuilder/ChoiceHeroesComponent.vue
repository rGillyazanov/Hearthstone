<template>
    <div class="container">
        <div class="row" style="height: calc(100vh - 66px)">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <div class="row">
                    <h1 class="text-center mx-auto pb-lg-5 mb-lg-0 font-weight-lighter">Выберите героя</h1>
                    <div class="col-lg-10 col-12 mx-auto">
                        <div class="row d-flex justify-content-between heroes">
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 11}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/DH_static.png" alt="Охотник на демонов">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 7}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/druid_static.png" alt="Друид">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 2}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/hunter_static.png" alt="Охотник">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 1}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/mage_static.png" alt="Маг">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 10}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/paladin_static.png" alt="Паладин">
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 col-12 mt-lg-5 mt-sm-2 mx-auto">
                        <div class="row d-flex justify-content-between heroes">
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 3}}">
                                    <img id="3" class="img-fluid" src="/images/hearthstone/heroes/priest_static.png" alt="Жрец">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 6}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/rogue_static.png" alt="Разбойник">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 8}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/tile_static.png" alt="Шаман">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 5}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/warlock_static.png" alt="Чернокнижник">
                                </router-link>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <router-link :to="{name: 'CardsForDeck', params: {id: 9}}">
                                    <img class="img-fluid" src="/images/hearthstone/heroes/warrior_static.png" alt="Воин">
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChoiceHeroesComponent",
        methods: {
            hoverImages() {
                $('.heroes div > a > img').hover(function () {
                    $(this).attr('src', (i, val) => {
                        return val.indexOf('static') !== -1 ? val.replace("static", "hover") : val.replace("hover", "static");
                    });
                });
            }
        },
        mounted() {
            this.hoverImages();
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