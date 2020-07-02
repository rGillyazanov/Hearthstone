<template>
    <div class="col-lg-12 col-12 mx-auto mb-5">
        <div class="row d-flex justify-content-center flex-wrap heroes">
            <template v-for="hero in heroes">
                <div class="col-md-3 col-sm-12" :key="hero.id">
                    <div class="position-absolute font-weight-regular text-center text-border text-white"
                         style="bottom: 100px; font-size: 1.5rem; width: 180px">
                        {{ trans.get('heroes.' + hero.name) }}
                    </div>
                    <router-link :to="{name: 'CardsForDeck', params: {id: hero.id}}">
                        <img class="img-fluid" :src="'/images/hearthstone/heroes/' + hero.name + '_static.png'" :alt="trans.get('heroes.' + hero.name)">
                    </router-link>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ShowHeroesComponent",
        props: {
            heroes: {
                type: Array,
                required: true
            }
        },
        methods: {
            hoverImages() {
                $('.heroes div').hover(function () {
                    $(this).find('a > img').attr('src', (i, val) => {
                        return val.indexOf('static') !== -1 ? val.replace("static", "hover") : val.replace("hover", "static");
                    });
                });
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.hoverImages();
            })
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