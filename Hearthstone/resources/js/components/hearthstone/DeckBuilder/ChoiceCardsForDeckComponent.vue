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
                                            <div id="cost" class="position-relative" @click="isNeutrals ? cardsOfCostNeutrals(mana - 1) : cardsOfCostHero(mana - 1)" v-for="(mana, index) in 11">
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
                    <div class="col-lg-3 col-md-12 pb-4 deck__block">
                        <div class="position-sticky mt-5" style="top: 20px;">
                            <span class="d-flex flex-column text-center">
                                <span class="d-flex justify-content-center align-items-center" v-if="!loadingHero">
                                    <img :src="'/images/hearthstone/heroesIcons/' + hero.name + '.png'" height="40" width="40" class="heroIcon">
                                    <div class="ml-3 h5 mb-0 text-border text-white">{{ trans.get('heroes.' + hero.name) }}</div>
                                </span>
                                <span class="h4 mt-3 mb-0 font-weight-bold text-border text-white">{{ countCardsInDeck }} / 30</span>
                                <div class="d-flex justify-content-center align-items-center" style="cursor: pointer" @click="changeFormatType" data-toggle="tooltip"
                                     data-placement="bottom" title="Нажмите, чтобы сменить формат колоды">
                                    <template v-if="deck.format === 2">
                                        <div class="formatImage">
                                            <img class="position-relative" style="top: 15px; width: 30px" src="/images/hearthstone/formatDeck/standard.png" alt="Стандартный">
                                        </div>
                                        <span class="ml-1 text-border font-weight-regular text-white" style="font-size: 1.1rem">Стандартная колода</span>
                                    </template>
                                    <template v-if="deck.format === 1">
                                        <div class="formatImage">
                                            <img class="position-relative" style="top: 15px; width: 30px" src="/images/hearthstone/formatDeck/wild.png" alt="Вольный">
                                        </div>
                                        <span class="ml-1 text-border font-weight-regular text-white" style="font-size: 1.1rem">Вольная колода</span>
                                    </template>
                                </div>
                            </span>
                            <div class="mt-5 text-center" v-if="countCardsInDeck === 0">
                                <span class="h6">Выберите карты, чтобы добавить их в колоду.</span>
                            </div>
                            <div class="cards-container overflow-auto px-2" style="height: 500px">
                                <div v-for="(card, index) in cardsImg" :key="index" :id="index">
                                    <div @click="removeCardFromDeck(index, $event)" class="card-tile" :aria-label="card.name" style="height: 34px; line-height: 34px; cursor: pointer">
                                        <div class="card-gem"
                                             :class="{
                                        'rarity-legendary': card.rarity_id === 4,
                                        'rarity-common': card.rarity_id === 1,
                                        'rarity-free': card.rarity_id === 5,
                                        'rarity-rare': card.rarity_id === 2,
                                        'rarity-epic': card.rarity_id === 3,
                                    }"
                                             style="width: 34px;"
                                        >
                                            <span class="card-cost" style="font-size: 1.25em;">{{ card.cost }}</span>
                                        </div>
                                        <div class="card-frame">
                                            <img class="card-asset" :class="{'count-one': card.count !== 2, 'count-two': card.count === 2}" :src="'https://art.hearthstonejson.com/v1/tiles/'+ card.id_card + '.png'" :alt="card.name">
                                            <div class="card-countbox" style="width: 24px;"  v-if="card.count === 2 || card.rarity_id === 4">
                                                <span class="card-count" style="font-size: 1.15em; top: -2px;" v-if="card.rarity_id === 4">★</span>
                                                <span class="card-count" style="font-size: 1.15em; top: -2px;" v-if="card.count === 2">{{ card.count }}</span>
                                            </div><span class="card-fade-countbox"></span>
                                            <figcaption class="card-name" style="font-size: 0.9em; width: calc(100% - 28px);">{{ card.name }}</figcaption>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-inline-flex justify-content-center align-items-center"
                                     data-toggle="tooltip"
                                     data-placement="bottom"
                                     title="Стоимость создания колоды">
                                    <img src="/images/hearthstone/icons/dust.png" alt="Стоимость колоды" height="18">
                                    <span class="ml-2 font-weight-regular">{{ deckCost }}</span>
                                </div>
                            </div>
                            <div class="row" v-if="countCardsInDeck === 30">
                                <div class="col-12 d-flex justify-content-center">
                                    <button @click="showCodeDeck" type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#exampleModal">
                                        Код колоды
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="countCardsInDeck === 30">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Код колоды</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input ref="inputCodeDeck" class="form-control" type="text" v-model="codeDeck" readonly>
                            <div class="badge badge-success mt-3" v-if="isCopy">Код колоды скопирован</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" @click="doCopy">Скопировать код колоды</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
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
    import { encode, decode, FormatType } from "deckstrings";

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
                    heroes: [],
                    format: FormatType.FT_STANDARD
                },
                deckCost: 0,
                isNeutrals: false,
                cardsImg: [],
                countCardsInDeck: 0,
                error: null,
                loading: null,
                loadingHero: null,
                isFind: null,
                isCopy: false
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
                axios.get('/api/cards/hero/' + this.heroId, {
                    params: {
                        format: this.deck.format
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
                        format: this.deck.format
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

                    this.deckCost += this.getCostCard(image.rarity_id);

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
                            if (value.dbfId === image.dbfId && value.count < 2 && image.rarity_id !== 4) {
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
                    this.deckCost -= this.getCostCard(this.cardsImg[index].rarity_id);
                    this.cardsImg[index].count = 1;
                    this.countCardsInDeck--;
                } else {
                    this.deckCost -= this.getCostCard(this.cardsImg[index].rarity_id);
                    this.cardsImg.splice(index, 1);
                    this.countCardsInDeck--;
                }
            },
            changeFormatType() {
                this.deck.format = this.deck.format === FormatType.FT_STANDARD ? this.deck.format = FormatType.FT_WILD : this.deck.format = FormatType.FT_STANDARD;
                this.deck.cards = [];
                this.cardsImg = [];
                this.countCardsInDeck = 0;
                this.deckCost = 0;
                this.getCardForHero();
                this.getNeutralsCards();
            },
            showCodeDeck() {
                this.isCopy = false;
                this.deck.cards = [];
                this.cardsImg.forEach(value => {
                    this.deck.cards.push([value.dbfId, value.count])
                });
                this.deck.cards.sort(function(a, b) {
                    return a[0] - b[0];
                });
                this.codeDeck = encode(this.deck);
            },
            cardsOfCostHero(cost) {
                this.error = null;
                this.loading = true;
                axios.get('/api/cards/hero/cost', {
                    params: {
                        cost: cost,
                        hero_id: this.heroId,
                        format: this.deck.format
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
                        format: this.deck.format
                    }
                }).then(response => {
                    this.neutralsCards = response.data.data;
                    this.loading = this.error = false;
                }).catch(error => {
                    this.error = true;
                    this.loading = false;
                });
            },
            doCopy() {
                this.$refs.inputCodeDeck.select();
                document.execCommand('copy');
                this.isCopy = true;
            },
            getCostCard(rarity_id) {
                switch (rarity_id) {
                    case 1:
                        return  50;
                    case 2:
                        return 100;
                    case 3:
                        return  400;
                    case 4:
                        return  1600;
                    default:
                        return 0;
                }
            },
            setHeroesId(heroId) {
                switch (parseInt(heroId)) {
                    case 1:
                        return 4;
                    case 2:
                        return 3;
                    case 3:
                        return 6;
                    case 5:
                        return 9;
                    case 6:
                        return 7;
                    case 7:
                        return 2;
                    case 8:
                        return 8;
                    case 9:
                        return 10;
                    case 10:
                        return 5;
                    case 11:
                        return 14;
                }
            }
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
        mixins: [image],
        components: {
            pagination
        },
        created() {
            this.deck.heroes.push(this.setHeroesId(this.$route.params.id));
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
    .formatImage {
        height: 65px;
        width: 59px;
        background-image: url("/images/hearthstone/formatDeck/block.png");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .deck__block {
        background-color: #e6e6e6;
        border-left: 1px solid;
        border-right: 1px solid;
    }

    .cost-text {
        position: absolute;
        top: 4px;
        left: 15px;
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }

    #cost {
        cursor: pointer;
    }

    #cost:last-child > span {
        left: 9px;
    }

    .heroIcon {
        cursor: pointer;
        border: 2px solid #ebe7e3;
        border-radius: 50%;
        box-shadow: 0px 0px 3px 2px rgba(0, 0, 0, 0.4);
    }

    .card-type-active {
        border-color: #fff700;
    }

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
            bottom: 0;
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