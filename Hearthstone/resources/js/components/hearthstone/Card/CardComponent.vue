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
            <div class="col-12" v-if="card">
                <div class="row">
                    <div class="col-3 d-flex flex-column justify-content-center">
                        <img :src="setImageCard(card.id_card)" height="387" width="256" :alt="card.name" class="image-card-rounded">
                        <div class="d-flex justify-content-center position-relative font-weight-regular" style="bottom: 20px">
                            <span data-toggle="tooltip"
                                  data-placement="bottom"
                                  title="Художник"
                            >
                                {{ card.artist }}
                            </span>
                        </div>
                    </div>
                    <div class="col-9 d-flex flex-column mt-5">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{ card.flavor }}</p>
                            <footer class="blockquote-footer">{{ card.name }}</footer>
                        </blockquote>
                        <p v-html="cardText" class="font-weight-regular"></p>
                        <div class="font-weight-regular" v-if="card.health || card.attack || card.cost">
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
                        </div>
                        <div>
                            <h5 class="mt-2">Параметры</h5>
                            <div class="card-parameters d-flex flex-column">
                                <div v-if="card.hero">Класс: <span class="ml-2">{{ card.hero.name }}</span></div>
                                <div v-if="card.type">Тип: <span class="ml-2">{{ card.type.name }}</span></div>
                                <div v-if="card.race">Раса: <span class="ml-2">{{ card.race.name }}</span></div>
                                <div v-if="card.rarity">Качество: <span class="ml-2">{{ card.rarity.name }}</span></div>
                                <div v-if="card.packset">Набор: <span class="ml-2">{{ card.packset.name }}</span></div>
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
        watch: {
            $route (toRoute) {
                this.id = toRoute.params['id']
            }
        },
        computed: {
            cardText() {
                return this.card.text.replace("#", "").replace("$", "").replace("[x]", "");
            }
        },
        mixins: [image],
        created() {
            this.error = this.card = null;
            this.loading = true;

            axios.get('/api/card/' + this.id).then(response => {
                this.error = this.loading = false;
                this.card = response.data.data;
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