<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center mt-5" v-if="!loadingHero">
                    <h2 class="font-weight-regular">
                        {{ trans.get('heroes.' + hero.name) }}:
                        <span v-if="format === 2">Стандарная колода</span>
                        <span v-else>Вольная колода</span>
                    </h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 d-flex flex-column justify-content-center" :class="{'two-card': card.count === 2}" v-for="card in cards">
                        <img :src="setImageCard(card.id_card)" height="350" width="220" :alt="card.name" class="image-card-rounded img-fluid mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {decode} from "deckstrings";
    import image from "../../../mixins/cards/image";

    export default {
        name: "DeckComponent",
        data() {
            return {
                cards: null,
                format: null,
                codeDeck: this.$route.params['code'],
                hero: null,
                loadingHero: null,
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
                axios.get('/api/heroes/' + this.setHeroesId(hero)).then(response => {
                    this.hero = response.data.data;
                    this.loadingHero = false;
                }).catch(error => {
                    this.loadingHero = false;
                });
            },
            getCardsOfDeck() {
                let deck = decode(this.codeDeck);

                let cardsInDeck = [];

                this.getHero(deck.heroes[0]);
                this.format = deck.format;

                deck.cards.forEach(item => {
                    cardsInDeck.push(item[0]);
                });

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
                    })
                }).catch(error => {
                    console.log(error);
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
                    case 14:
                        return 11;
                }
            }
        },
        created() {
            this.getCardsOfDeck();
        }
    }
</script>

<style scoped>
    .two-card {
        background: url("/images/hearthstone/icons/x2.png") no-repeat 113px 292px;
    }
</style>