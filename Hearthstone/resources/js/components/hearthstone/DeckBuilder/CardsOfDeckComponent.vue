<template>
    <div class="col-lg-3 col-md-12 pb-4 deck__block">
        <div class="position-sticky mt-5" style="top: 20px;">
            <span class="d-flex flex-column text-center">
                <span class="d-flex justify-content-center align-items-center">
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
</template>

<script>
    import { encode, FormatType } from "deckstrings";
    import costCard from "../../../mixins/cards/costCard";

    export default {
        name: "CardsOfDeckComponent",
        data() {
            return {
                codeDeck: '',
                isCopy: false,
                deck: {
                    cards: [],
                    heroes: [],
                    format: FormatType.FT_STANDARD
                }
            }
        },
        props: {
            cardsImg: Array,
            hero: Object,
            deckCost: Number,
            countCardsInDeck: Number
        },
        watch: {
            deckCost(newValue) {
                this.cost = newValue;
            },
            countCardsInDeck(newValue) {
                this.countCards = newValue;
            }
        },
        mixins: [costCard],
        methods: {
            changeFormatType() {
                this.deck.format = this.deck.format === FormatType.FT_STANDARD ? this.deck.format = FormatType.FT_WILD : this.deck.format = FormatType.FT_STANDARD;
                this.$emit("update-format", this.deck.format);
                this.deck.cards = [];
                this.cost = 0;
                this.countCards = 0;
                this.$emit("update-cardsImg", []);
                this.$emit("update-countCards", this.countCards);
                this.$emit("update-cost", this.cost);
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
                this.deck.heroes.push(this.setHeroesId(this.hero.id));
                this.codeDeck = encode(this.deck);
            },
            doCopy() {
                this.$refs.inputCodeDeck.select();
                document.execCommand('copy');
                this.isCopy = true;
            },
            removeCardFromDeck(index) {
                if (this.cardsImg[index].count === 2) {
                    this.cost -= this.getCostCard(this.cardsImg[index].rarity_id);
                    this.$emit("update-cost", this.cost);
                    this.cardsImg[index].count = 1;
                    this.countCards--;
                    this.$emit("update-countCards", this.countCards);
                } else {
                    this.cost -= this.getCostCard(this.cardsImg[index].rarity_id);
                    this.$emit("update-cost", this.cost);
                    this.cardsImg.splice(index, 1);
                    this.countCards--;
                    this.$emit("update-countCards", this.countCards);
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
                        return 893;
                    case 6:
                        return 930
                    case 7:
                        return 274;
                    case 8:
                        return 1066;
                    case 9:
                        return 7;
                    case 10:
                        return 5;
                    case 11:
                        return 14;
                }
            }
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
        border-bottom: 1px solid;
    }

    .card-type-active {
        border-color: #ffffff;
    }

    .cards-container::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .cards-container::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    .cards-container::-webkit-scrollbar-thumb {
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