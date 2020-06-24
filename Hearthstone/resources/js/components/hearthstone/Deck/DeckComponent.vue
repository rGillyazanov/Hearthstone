<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12" v-for="card in cards">
                        <img :src="setImageCard(card.id_card)" height="387" width="256" :alt="card.name" class="image-card-rounded img-fluid mx-auto">
                        <div class="d-flex justify-content-center align-items-center position-relative" style="bottom: 42px" v-if="card.count === 2">
                            <img src="/images/hearthstone/icons/count_card_in_deck.png">
                            <span class="d-block font-weight-regular position-absolute text-white text-border pb-2" style="font-size: 17px">x{{ card.count }}</span>
                        </div>
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
                codeDeck: this.$route.params['code']
            }
        },
        mixins: [image],
        watch: {
            codeDeck() {
                this.codeDeck = this.$route.params['code']
            }
        },
        created() {
            let deck = decode(this.codeDeck);

            let cardsInDeck = [];
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
        }
    }
</script>

<style scoped>
    .two-card {
        position: relative;
        bottom: 60px;
        left: 124px;
    }
</style>