<template>
    <div class="container-fluid">
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
                        <div class="col-12 d-flex justify-content-center align-items-center" v-if="!isFind">
                            <h1 class="alert alert-danger">Карт не найдено</h1>
                        </div>
                        <div class="row">
                            <div class="col-12 justify-content-start" v-if="!loadingHero">
                                <div class="mt-4 ml-5">
                                    <img @click="isNeutrals = false"
                                         data-toggle="tooltip"
                                         data-placement="top"
                                         :title="trans.get('heroes.' + hero.name)"
                                         :src="'/images/hearthstone/heroesIcons/' + hero.name + '.png'">
                                    <img @click="isNeutrals = true"
                                         data-toggle="tooltip"
                                         data-placement="top"
                                         title="Общие" class="ml-3" :src="'/images/hearthstone/heroesIcons/neutrals.png'">
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
                    </div>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <div class="position-sticky mt-5" style="top: 20px;">
                            <span class="d-flex flex-column text-center">
                                <span class="d-flex justify-content-center align-items-center" v-if="!loadingHero">
                                    <img :src="'/images/hearthstone/heroesIcons/' + hero.name + '.png'" height="40" width="40">
                                    <div class="ml-3 h5 mb-0">{{ trans.get('heroes.' + hero.name) }}</div>
                                </span>
                                <span class="h4 mt-3 font-weight-regular">{{ countCardsInDeck }} / 30</span>
                            </span>
                            <div class="mt-5 text-center" v-if="countCardsInDeck === 0">
                                <span class="h6">Выберите карты, чтобы добавить их в колоду.</span>
                            </div>
                            <div class="cards-container overflow-auto px-2" style="height: 500px">
                                <div v-for="(card, index) in cardsImg" :key="index" :id="index">
                                    <div @click="removeCardFromDeck(index, $event)" class="card-tile" :aria-label="card.name" style="height: 34px; line-height: 34px; cursor: pointer">
                                        <div class="card-gem"
                                             :class="{
                                        'rarity-legendary': card.rarity_id === '4',
                                        'rarity-common': card.rarity_id === '1',
                                        'rarity-free': card.rarity_id === '5',
                                        'rarity-rare': card.rarity_id === '2',
                                        'rarity-epic': card.rarity_id === '3',
                                    }"
                                             style="width: 34px;"
                                        >
                                            <span class="card-cost" style="font-size: 1.25em;">{{ card.cost }}</span>
                                        </div>
                                        <div class="card-frame">
                                            <img class="card-asset" :class="{'count-one': card.count !== 2, 'count-two': card.count === 2}" :src="'https://art.hearthstonejson.com/v1/tiles/'+ card.id_card + '.png'" :alt="card.name">
                                            <div class="card-countbox" style="width: 24px;"  v-if="card.count === 2 || card.rarity_id === '4'">
                                                <span class="card-count" style="font-size: 1.15em; top: -2px;" v-if="card.rarity_id === '4'">★</span>
                                                <span class="card-count" style="font-size: 1.15em; top: -2px;" v-if="card.count === 2">{{ card.count }}</span>
                                            </div><span class="card-fade-countbox"></span>
                                            <figcaption class="card-name" style="font-size: 0.9em; width: calc(100% - 28px);">{{ card.name }}</figcaption>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="countCardsInDeck === 30">
                                <div class="col-12 flex-column">
                                    <button class="btn btn-primary mt-3" @click="showCodeDeck" >Показать код колоды</button>
                                    <input class="form-control mt-3" type="text" :value="codeDeck" readonly v-if="codeDeck.length !== 0">
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
    import pagination from "laravel-vue-pagination";
    import { encode, FormatType } from "deckstrings";

    export default {
        name: "ChoiceCardsForDeckComponent",
        data() {
            return {
                heroId: this.$route.params.id,
                hero: null,
                cardsOfHero: null,
                neutralsCards: null,
                codeDeck: '',
                deck: {
                    cards: [],
                    heroes: [
                        parseInt(this.$route.params.id)
                    ],
                    format: null
                },
                isNeutrals: false,
                cardsImg: [],
                countCardsInDeck: 0,
                error: null,
                loading: null,
                loadingHero: null,
                isFind: null
            }
        },
        watch: {
            $route (toRoute, fromRoute) {
                this.heroId = toRoute.params['id']
            }
        },
        methods: {
            getCardForHero() {
                this.error = this.cardsOfHero = this.neutralsCards = null;
                this.loading = true;
                axios.get('/api/cards/hero/' + this.heroId).then(response => {
                    this.cardsOfHero = response.data.data.cardsOfHero;
                    this.neutralsCards = response.data.data.neutralsCards;
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
                    this.cardsOfHero = response.data.data.cardsOfHero;
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
                    this.neutralsCards = response.data.data.neutralsCards;
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
                        rarity_id: event.currentTarget.dataset.rarityid,
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
                        this.countCardsInDeck++;
                    } else {
                        // Если карта в колоде и она не легендарная, добавляем вторую.
                        this.cardsImg.forEach((value, index) => {
                            if (value.dbfId === image.dbfId && value.count < 2 && image.rarity_id !== '4') {
                                this.cardsImg[index].count = 2;
                                this.countCardsInDeck++;
                            }
                        })
                    }

                    this.cardsImg.sort(function (a, b) {
                        return (b.cost < a.cost) - (a.cost < b.cost) || (b.name < a.name) - (a.name < b.name);
                    });
                }
            },
            removeCardFromDeck(index, event) {
                if (this.cardsImg[index].count === 2) {
                    this.cardsImg[index].count = 1;
                    this.countCardsInDeck--;
                } else {
                    this.cardsImg.splice(index, 1);
                    this.countCardsInDeck--;
                }
            },
            showCodeDeck() {
                this.deck.cards = [];
                this.cardsImg.forEach(value => {
                    this.deck.cards.push([value.dbfId, value.count])
                });
                this.deck.cards.sort(function(a, b) {
                    return a[0] - b[0];
                });

                this.deck.format = FormatType.FT_STANDARD;
                this.codeDeck = encode(this.deck);
            }
        },
        updated() {
            // Когда страница загружена, проверяем найдены ли карты
            this.$nextTick(() => {
                if (!this.loading)
                    this.isFind = this.cardsOfHero.data.length !== 0 || this.neutralsCards.data.length !== 0;

                $('[data-toggle="tooltip"]').tooltip();
            })
        },
        mixins: [image],
        components: {
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
        }
    }
</script>

<style lang="scss" scoped>

    .cards-container::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .cards-container::-webkit-scrollbar
    {
        width: 5px;
        background-color: #F5F5F5;
    }

    .cards-container::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #315376;
    }

    .count-one {
        right: 0;
    }
    .count-two {
        right: 22px;
    }

    .card-tile {
        color: #fff;
        position: relative;
        text-align: left;
        cursor: default;

        padding-top: 1px;
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000,
        1px 1px 0 #000;

        .card-gem {
            height: 100%;
            float: left;
            position: relative;
            background: #315376;
            border-style: solid;
            border-color: black;
            border-width: 1px 0 1px 1px;

        .card-cost {
            position: absolute;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        &.rarity-common,
        &.rarity-free {
             background: #858585;
         }

        &.rarity-rare {
             background: #315376;
         }

        &.rarity-epic {
             background: #644c82;
         }

        &.rarity-legendary {
             background: #855c25;
         }
        }

        &.premium .card-gem {
             background-color: gold;
        }

        .card-tier {
            height: 100%;
            float: left;
            position: relative;
            border-style: solid;
            border-color: black;
            border-width: 1px 0 1px 1px;
        }

        .card-frame {
            position: relative;
            border: solid 1px black;
            height: 100%;
            overflow: hidden;

        .card-fade-countbox {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                    65deg,
                    rgba(49, 49, 9, 1) 0%,
                    rgba(49, 49, 49, 1) calc(100% - 120px),
                    rgba(49, 49, 49, 0) calc(100% - 50px),
                    rgba(49, 49, 49, 0) 100%
            );
        }

        .card-fade-no-countbox {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                    65deg,
                    rgba(49, 49, 9, 1) 0%,
                    rgba(49, 49, 49, 1) calc(100% - 96px),
                    rgba(49, 49, 49, 0) calc(100% - 26px),
                    rgba(49, 49, 49, 0) 100%
            );
        }

        .card-name {
            position: absolute;
            font-weight: bold;
            left: 5px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-name.premium {
            color: gold;
        }

        .card-asset {
            position: absolute;
            height: 100%;
            background-color: #313131;
        }
    }

    .card-countbox {
        float: right;
        position: relative;
        background-color: #313131;
        border-left: solid 1px black;
        height: 100%;

        .card-legendicon {
            position: absolute;
            top: -1px;
        }

        .card-count {
            position: absolute;
            width: 100%;
            color: #f4d442;
            font-weight: bold;
            text-align: center;
        }
    }

    .card-image {
        position: fixed;
        z-index: 1000;
    }

    &.predicted {
         opacity: 0.4;
         filter: grayscale(1);

        &:hover {
             filter: grayscale(0);
         }
    }

    &.craftable {
         opacity: 0.6;

        a:hover &,
        a:focus & {
            opacity: 0.8;
        }
    }

    a:hover &,
    a:focus & {
        cursor: pointer;

        > * {
            filter: brightness(115%);
        }
        .card-image {
            filter: none;
        }
    }
}
</style>