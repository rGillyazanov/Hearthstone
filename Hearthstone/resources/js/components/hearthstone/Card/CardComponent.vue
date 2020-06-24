<template>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center" style="height: calc(100vh - 55px)" v-if="loading">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center align-items-center" style="height: calc(100vh - 55px)" v-if="error">
                <h1>Ошибка при загрузке карты</h1>
            </div>
            <div class="col-10 offset-1" v-if="card">
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="row d-flex flex-column justify-content-center">
                            <img :src="setImageCard(card.id_card)" height="387" width="256" :alt="card.name" class="image-card-rounded img-fluid mx-auto">
                            <div class="d-flex justify-content-center position-relative font-weight-regular" style="bottom: 20px">
                                <span data-toggle="tooltip"
                                      data-placement="bottom"
                                      title="Художник"
                                >
                                    {{ card.artist }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12 d-flex flex-column mt-lg-5 pb-3">
                        <blockquote class="blockquote">
                            <p class="mb-0" v-html="cardFlavor"></p>
                            <footer class="blockquote-footer">{{ card.name }}</footer>
                        </blockquote>
                        <p v-html="cardText" class="font-weight-regular"></p>
                        <div class="font-weight-regular mt-2" v-if="card.health || card.attack || card.cost">
                            <h5>Характеристики</h5>
                            <div v-if="card.health" class="health d-flex align-items-center">
                                <img src="/images/hearthstone/icons/Health.png" alt="Здоровье"><span class="ml-2">{{ card.health }}</span>
                            </div>
                            <div v-if="card.attack" class="attack d-flex align-items-center">
                                <img src="/images/hearthstone/icons/Attack.png" alt="Атака"><span class="ml-2">{{ card.attack }}</span>
                            </div>
                            <div v-if="card.cost" class="attack d-flex align-items-center">
                                <img src="/images/hearthstone/icons/Mana.png" alt="Мана"><span class="ml-2">{{ card.cost }}</span>
                            </div>
                            <div v-if="card.rarity_id !== 5" class="attack d-flex align-items-center">
                                <img style="margin-left: 2px" src="/images/hearthstone/icons/dust.png" alt="Мана"
                                     data-toggle="tooltip"
                                     data-placement="bottom"
                                     title="Стоимость создания карты"
                                >
                                <span class="ml-2">{{ card.dust.common }} / {{ card.dust.gold }} (Золотая)</span>
                            </div>
                        </div>
                        <div>
                            <h5 class="mt-3">Параметры</h5>
                            <div class="card-parameters d-flex flex-column">
                                <div v-if="card.hero">Класс: <span class="ml-2">{{ trans.get('heroes.' + card.hero.name) }}</span></div>
                                <div v-if="card.type">Тип: <span class="ml-2">{{ trans.get('types.' + card.type.name) }}</span></div>
                                <div v-if="card.race">Раса: <span class="ml-2">{{ trans.get('races.' + card.race.name) }}</span></div>
                                <div v-if="card.rarity">Качество: <span class="ml-2">{{ trans.get('rarities.' + card.rarity.name) }}</span></div>
                                <div v-if="card.packset">Набор: <span class="ml-2">{{ trans.get('packsets.' + card.packset.name) }}</span></div>
                            </div>
                            <h5 class="mt-3" v-if="card.mechanics.length !== 0">Механики</h5>
                            <div class="d-flex flex-column">
                                <div v-for="mechanic in card.mechanics">
                                    <span data-toggle="tooltip"
                                          data-placement="bottom"
                                          :title="trans.get('mechanics.' + mechanic.name + '.description')">
                                        {{ trans.get('mechanics.' + mechanic.name + '.name') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import image from "../../../mixins/cards/image";

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
        methods: {
            getCostOfCard(rarity) {
                let costCommon, costGold = 0;
                switch (rarity) {
                    case 1:
                        costCommon = 50;
                        costGold = costCommon * 8;
                        break;
                    case 2:
                        costCommon = 100;
                        costGold = costCommon * 8;
                        break;
                    case 3:
                        costCommon = 400;
                        costGold = costCommon * 4;
                        break;
                    case 4:
                        costCommon = 1600;
                        costGold = costCommon * 2;
                        break;
                }

                return {
                    common: costCommon,
                    gold: costGold
                };
            }
        },
        watch: {
            $route (toRoute) {
                this.id = toRoute.params['id']
            }
        },
        computed: {
            cardText() {
                return this.card.text != null ? this.card.text.replace("#", "").replace("$", "").replace("[x]", ""): '';
            },
            cardFlavor() {
                return this.card.flavor != null ? this.card.flavor.replace("#", "").replace("$", "").replace("[x]", "") : '';
            }
        },
        mixins: [image],
        created() {
            this.error = this.card = null;
            this.loading = true;

            axios.get('/api/card/' + this.id).then(response => {
                this.error = this.loading = false;
                this.card = response.data.data;
                this.card.dust = this.getCostOfCard(this.card.rarity_id);
            }).catch(error => {
                this.loading = false;
                this.error = true;
            });
        },
        updated() {
            this.$nextTick(() => {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }
    }
</script>

<style scoped>

</style>