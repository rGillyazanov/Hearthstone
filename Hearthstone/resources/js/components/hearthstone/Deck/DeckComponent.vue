<template>
    <div class="container">
        <div class="row">
            <div class="col-12" v-if="!loadingCard">
                <div class="d-flex flex-column justify-content-center mt-5" v-if="!loadingHero">
                    <h2 class="font-weight-regular text-center">
                        {{ trans.get('heroes.' + hero.name) }}:
                        <span v-if="format === 2">Стандарная колода</span>
                        <span v-else>Вольная колода</span>
                    </h2>
                    <h5 class="d-flex flex-column justify-content-center align-items-center font-weight-regular my-4">
                        <span>Существ: {{ typesCounter.minions }}</span>
                        <span class="my-2">Заклинаний: {{ typesCounter.spells }}</span>
                        <span>Оружия: {{ typesCounter.weapons }}</span>
                    </h5>
                </div>
                <div class="row my-4">
                    <div class="col-lg-4 col-12 mb-lg-0 mb-5 d-flex justify-content-center">
                        <deck-histogram color="red" :cards="cards" attribute="health" title="Гистограмма здоровья"></deck-histogram>
                    </div>
                    <div class="col-lg-4 col-12 mb-lg-0 mb-5 d-flex justify-content-center">
                        <deck-histogram color="blue" :cards="cards" attribute="cost" title="Гистограмма маны"></deck-histogram>
                    </div>
                    <div class="col-lg-4 col-12 mb-lg-0 mb-5 d-flex justify-content-center">
                        <deck-histogram color="orange" :cards="cards" attribute="attack" title="Гистограмма атаки"></deck-histogram>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12 my-4">
                        <input type="text" class="form-control" :value="codeDeck" readonly>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-3 col-md-4 col-12"
                         :class="{'two-card': card.count === 2}"
                         v-for="card in cards">
                        <router-link class="d-flex flex-column justify-content-center" :to="{name: 'Card', params: {id: card.id}}">
                            <img :src="setImageCard(card.id_card)" height="350" width="220"
                                 :alt="card.name"
                                 class="image-card-rounded img-fluid mx-auto">
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {decode} from "deckstrings";
    import image from "../../../mixins/cards/image";
    import DeckHistogram from "./DeckHistogram";

    export default {
        name: "DeckComponent",
        components: {DeckHistogram},
        data() {
            return {
                cards: null,
                format: null,
                codeDeck: this.$route.params['code'],
                hero: null,
                loadingHero: null,
                loadingCard: null,
                typesCounter: {
                    weapons: 0,
                    minions: 0,
                    spells: 0
                }
            }
        },
        mixins: [image],
        watch: {
            $route (toRoute) {
                this.codeDeck = toRoute.params['code']
            }
        },
        methods: {
            getHero(hero) {
                this.loadingHero = true;
                this.hero = null;
                console.log(hero);
                axios.get('/api/heroes/' + this.setHeroesId(hero)).then(response => {
                    this.hero = response.data.data;
                    this.loadingHero = false;
                }).catch(error => {
                    this.loadingHero = false;
                });
            },
            getCardsOfDeck() {
                let deck = {};

                try {
                    deck = decode(this.codeDeck);
                }
                catch (e) {
                    this.$router.push({ name: 'Home' })
                }

                let cardsInDeck = [];

                this.getHero(deck.heroes[0]);
                this.format = deck.format;

                deck.cards.forEach(item => {
                    cardsInDeck.push(item[0]);
                });

                this.loadingCard = true;
                axios.get('/api/deck/import', {
                    params: {
                        'cardsId': JSON.stringify(cardsInDeck)
                    }
                }).then(response => {
                    this.cards = response.data.data;
                    deck.cards.forEach(card => {
                        this.cards.forEach((cardDB, index) => {
                            if (card[0] === cardDB.dbfId) {
                                this.$set(this.cards[index], 'count', card[1]);
                            }
                        })
                    });
                    this.loadingCard = false;
                    this.getTypesCards();
                }).catch(error => {
                    console.log(error);
                    this.loadingCard = false;
                })
            },
            setHeroesId(heroId) {
                switch (parseInt(heroId)) {
                    case 4:
                    case 637:
                        return 1;
                    case 3:
                    case 31:
                        return 2;
                    case 41887:
                    case 813:
                    case 6:
                        return 3;
                    case 893:
                        return 5;
                    case 930:
                    case 40195:
                        return 6
                    case 274:
                        return 7;
                    case 1066:
                        return 8;
                    case 7:
                        return 9;
                    case 671:
                    case 5:
                        return 10;
                    case 56550:
                    case 60238:
                    case 14:
                        return 11;
                }
            },
            getTypesCards() {
                this.cards.forEach(card => {
                    if (card.count === 2) {
                        if (card.type.name === "MINION")
                            this.typesCounter.minions += 2;
                        else if (card.type.name === "SPELL")
                            this.typesCounter.spells += 2;
                        else if (card.type.name === "WEAPON")
                            this.typesCounter.weapons += 2;
                    } else if (card.count === 1) {
                        if (card.type.name === "MINION")
                            this.typesCounter.minions++;
                        else if (card.type.name === "SPELL")
                            this.typesCounter.spells++;
                        else if (card.type.name === "WEAPON")
                            this.typesCounter.weapons++;
                    }
                })
            }
        },
        created() {
            this.getCardsOfDeck();
        },
        updated() {
            this.$nextTick(() => {
                $('[data-toggle="tooltip"]').tooltip();
            });
        }
    }
</script>

<style scoped>
    .two-card {
        background: url("/images/hearthstone/icons/x2.png") no-repeat 50% 292px;
    }

    @media (min-width: 768px) and (max-width: 1199.98px) {
        .two-card {
            background: url("/images/hearthstone/icons/x2.png") no-repeat 50% 279px
        }
    }
</style>