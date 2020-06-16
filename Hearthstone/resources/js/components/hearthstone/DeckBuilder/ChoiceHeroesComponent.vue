<template>
    <div class="container">
        <div class="row" style="height: calc(100vh - 66px)">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <div class="row">
                    <h1 class="text-center mx-auto pb-lg-5 mb-lg-0 font-weight-lighter">Выберите героя</h1>
                    <div class="col-lg-10 col-12 mx-auto">
                        <div class="row d-flex justify-content-between heroes">
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/DH_static.png" alt="Охотник на демонов">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/druid_static.png" alt="Друид">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/hunter_static.png" alt="Охотник">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/mage_static.png" alt="Маг">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/paladin_static.png" alt="Паладин">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 col-12 mt-lg-5 mt-sm-2 mx-auto">
                        <div class="row d-flex justify-content-between heroes">
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/priest_static.png" alt="Жрец">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/rogue_static.png" alt="Разбойник">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/tile_static.png" alt="Шаман">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/warlock_static.png" alt="Чернокнижник">
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <img class="img-fluid" src="/images/hearthstone/heroes/warrior_static.png" alt="Воин">
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
                $('.heroes div > img').hover(function () {
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