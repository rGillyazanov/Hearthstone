<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row d-flex flex-wrap-reverse">
                    <div class="col-lg-9 col-xs-12" v-if="loading">
                        <div class="row d-flex align-items-center justify-content-center" style="height: calc(100vh - 66px)">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xs-12 d-flex justify-content-center align-items-center" v-if="error">
                        <h1 class="alert alert-danger">Ошибка при получении карт</h1>
                    </div>
                    <div class="col-lg-9 col-xs-12 d-flex flex-column" v-if="cardsOfHero && !loading">
                        <div class="row">
                            <div class="col-12" v-if="!loadingHero">
                                <div class="row mt-4 d-flex justify-content-between align-items-center">
                                    <div class="ml-md-5 col-12 col-md-2 d-flex justify-content-center">
                                        <img @click="isNeutrals = false"
                                             data-toggle="tooltip"
                                             data-placement="top"
                                             :title="trans.get('heroes.' + hero.name)"
                                             class="heroIcon"
                                             :class="{'card-type-active': !isNeutrals}"
                                             height="60"
                                             width="60"
                                             :src="'/images/hearthstone/heroesIcons/' + hero.name + '.png'">
                                        <img @click="isNeutrals = true"
                                             data-toggle="tooltip"
                                             data-placement="top"
                                             :class="{'card-type-active': isNeutrals}"
                                             height="60"
                                             width="60"
                                             title="Общие" class="ml-3 heroIcon" :src="'/images/hearthstone/heroesIcons/neutrals.png'">
                                    </div>
                                    <div class="col-12 col-md-9 d-flex justify-content-center justify-content-md-end mt-3 mt-md-0">
                                        <div class="row pr-md-5">
                                            <div id="cost" class="position-relative" @click="isNeutrals ? cardsOfCostNeutrals(mana - 1) : cardsOfCostHero(mana - 1)" v-for="mana in 11">
                                                <span class="cost-text text-border">{{ mana - 1}}</span>
                                                <img :src="'/images/hearthstone/icons/mana_Input.png'" height="40" width="40">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template v-if="isNeutrals">
                                <div v-for="card in neutralsCards.data" :key="card.id" class="col-lg-3 col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
                                    <img @click="addCardInDeck($event)"
                                         :data-dbfId="card.dbfId"
                                         :data-rarityId="card.rarity_id"
                                         :data-cost="card.cost"
                                         :data-idcard="card.id_card"
                                         :data-name="card.name"
                                         :src="setImageCard(card.id_card)" height="300" :alt="card.name" class="img-fluid image-card-rounded" style="cursor: pointer">
                                </div>
                            </template>
                            <template v-else>
                                <div v-for="card in cardsOfHero.data" :key="card.id" class="col-lg-3 col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
                                    <img @click="addCardInDeck($event)"
                                         :data-dbfId="card.dbfId"
                                         :data-rarityId="card.rarity_id"
                                         :data-cost="card.cost"
                                         :data-idcard="card.id_card"
                                         :data-name="card.name"
                                         :src="setImageCard(card.id_card)" height="300" :alt="card.name" class="img-fluid image-card-rounded" style="cursor: pointer">
                                </div>
                            </template>
                        </div>
                        <pagination v-if="isNeutrals" :limit="2" align="center" :data="neutralsCards" @pagination-change-page="getNeutralsCardsPaginate"></pagination>
                        <pagination v-else :limit="2" align="center" :data="cardsOfHero" @pagination-change-page="getCardsOfHeroPaginate"></pagination>
                        <div class="h-100 d-flex justify-content-center align-items-center" v-if="!isFind">
                            <h1 class="alert alert-danger">Карт не найдено</h1>
                        </div>
                    </div>
                    <cards-of-deck-component
                            :hero="hero"
                            :cards-img="cardsImg"
                            :deck-cost="deckCost"
                            @update-cost="updateCost"
                            v-if="!loadingHero"
                            :count-cards-in-deck="countCardsInDeck"
                            @update-countCards="updateCountCards"
                            @update-cardsImg="updateCardsImg"
                            @update-format="updateFormat"
                    >
                    </cards-of-deck-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import image from "../../../mixins/cards/image";
    import pagination from "laravel-vue-pagination";
    import CardsOfDeckComponent from "./CardsOfDeckComponent";
    import { FormatType } from "deckstrings";
    import costCard from "../../../mixins/cards/costCard";

    export default {
        name: "ChoiceCardsForDeckComponent",
        data() {
            return {
                heroId: this.$route.params.id,
                hero: null,
                cardsOfHero: null,
                neutralsCards: null,
                cardsImg: [],
                deckCost: 0,
                countCardsInDeck: 0,
                format: FormatType.FT_STANDARD,
                error: null,
                loading: null,
                isFind: null,
                isNeutrals: false,
                loadingHero: null,
            }
        },
        watch: {
            $route (toRoute, fromRoute) {
                this.heroId = toRoute.params['id']
            }
        },
        methods: {
            updateCost(newValue) {
                this.deckCost = newValue;
            },
            updateCountCards(newValue) {
                this.countCardsInDeck = newValue;
            },
            updateCardsImg(newValue) {
                this.cardsImg = newValue;
                this.getCardForHero();
                this.getNeutralsCards();
            },
            updateFormat(newValue) {
                this.format = newValue;
            },
            getCardForHero() {
                this.error = this.cardsOfHero = this.neutralsCards = null;
                this.loading = true;
                axios.get('/api/cards/hero/' + this.heroId, {
                    params: {
                        format: this.format
                    }
                }).then(response => {
                    this.cardsOfHero = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
            getNeutralsCards() {
                this.error = this.cardsOfHero = this.neutralsCards = null;
                this.loading = true;
                axios.get('/api/cards/hero/neutrals', {
                    params: {
                        format: this.format
                    }
                }).then(response => {
                    this.neutralsCards = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
            getCardsOfHeroPaginate(page = 1) {
                this.error = null;
                this.loading = true;
                // Ссылка на следуюшую страницу, такая же как у первой, но меняется page
                axios.get(this.cardsOfHero.first_page_url.match(/(.*?)page=/g) + page).then(response => {
                    this.cardsOfHero = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
            getNeutralsCardsPaginate(page = 1) {
                this.error = null;
                this.loading = true;
                // Ссылка на следуюшую страницу, такая же как у первой, но меняется page
                axios.get(this.neutralsCards.first_page_url.match(/(.*?)page=/g) + page).then(response => {
                    this.neutralsCards = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
            addCardInDeck(event) {
                // Если карт в колоде меньше 30
                if (this.countCardsInDeck < 30) {
                    let image = {
                        id_card: event.currentTarget.dataset.idcard,
                        name: event.currentTarget.dataset.name,
                        rarity_id: parseInt(event.currentTarget.dataset.rarityid),
                        cost: parseInt(event.currentTarget.dataset.cost),
                        dbfId: parseInt(event.currentTarget.dataset.dbfid),
                        count: 1
                    }

                    // Проверяем существует ли карта в колоде
                    let cardExitsInDeck = this.cardsImg.find(function (value) {
                        return value.dbfId === image.dbfId;
                    });

                    // Если карты нет в колоде, добавляем.
                    if (!cardExitsInDeck) {
                        this.$set(this.cardsImg, this.cardsImg.length, image);
                        this.deckCost += this.getCostCard(image.rarity_id);
                        this.countCardsInDeck++;
                    } else {
                        // Если карта в колоде и она не легендарная, добавляем вторую.
                        this.cardsImg.forEach((value, index) => {
                            if (value.dbfId === image.dbfId && value.count < 2 && image.rarity_id !== 4) {
                                this.cardsImg[index].count = 2;
                                this.deckCost += this.getCostCard(image.rarity_id);
                                this.countCardsInDeck++;
                            }
                        })
                    }

                    this.cardsImg.sort(function (a, b) {
                        return (b.cost < a.cost) - (a.cost < b.cost) || (b.name < a.name) - (a.name < b.name);
                    });
                }
            },
            cardsOfCostHero(cost) {
                this.error = null;
                this.loading = true;
                axios.get('/api/cards/hero/cost', {
                    params: {
                        cost: cost,
                        hero_id: this.heroId,
                        format: this.format
                    }
                }).then(response => {
                    this.cardsOfHero = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
            cardsOfCostNeutrals(cost) {
                this.error = null;
                this.loading = true;
                axios.get('/api/cards/hero/cost', {
                    params: {
                        cost: cost,
                        hero_id: 4,
                        format: this.format
                    }
                }).then(response => {
                    this.neutralsCards = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
        },
        updated() {
            // Когда страница загружена, проверяем найдены ли карты
            this.$nextTick(() => {
                if (!this.loading)
                    if (this.cardsOfHero)
                        this.isFind = this.cardsOfHero.data.length !== 0;
                    else if (this.neutralsCards)
                        this.isFind = this.neutralsCards.data.length !== 0;

                $('[data-toggle="tooltip"]').tooltip();
            })
        },
        mixins: [image, costCard],
        components: {
            CardsOfDeckComponent,
            pagination
        },
        created() {
            this.loadingHero = true;
            this.hero = null;
            axios.get('/api/heroes/' + this.heroId).then(response => {
                this.hero = response.data.data;
                this.loadingHero = false;
            }).catch(error => {
                this.loadingHero = false;
            });
            this.getCardForHero();
            this.getNeutralsCards();
        }
    }
</script>

<style lang="scss" scoped>
    #cost {
        cursor: pointer;
    }

    #cost:last-child > span {
        left: 9px;
    }

    .cost-text {
        position: absolute;
        top: 4px;
        left: 15px;
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }
</style>