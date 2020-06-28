<template>
    <div>
        <div class="block" :style="{'border-color': color}" v-for="(blockNumber, index) in 7">
            <div class="background-histogram" :style="{'background-color': color, 'height': 5 + '%'}"></div>
            <div class="d-block position-absolute w-100 font-weight-regular text-center"
                 style="bottom: -25px"
                 v-if="index !== 6">
                {{ blockNumber }}
            </div>
            <div class="d-block position-absolute w-100 font-weight-regular text-right"
                 style="bottom: -25px"
                 v-else>
                {{ blockNumber + '+' }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DeckHistogram",
        props: {
            color: String,
            cards: Array,
            attribute: String
        },
        created() {
            cards.forEach((item, index) => {
                cards.forEach(item2 => {

                });
            })
        }
    }
</script>

<style scoped>
    .block {
        position: relative;
        display: inline-block;
        height: 120px;
        width: 30px;
        border-width: 1px;
        border-style: solid;
    }

    .block:not(:first-child) {
        margin-left: 5px;
    }

    .background-histogram {
        position: absolute;
        width: 100%;
        bottom: 0;
        left: 0;
    }
</style>