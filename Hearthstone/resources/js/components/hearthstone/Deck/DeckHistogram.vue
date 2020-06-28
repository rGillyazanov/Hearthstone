<template>
    <div>
        <div :id="attribute" class="block" :style="{'border-color': color}" v-for="(blockNumber, index) in 8">
            <div class="background-histogram" :style="{'background-color': color}"></div>
            <div class="d-block position-absolute w-100 font-weight-regular text-center"
                 style="bottom: -25px"
                 v-if="index !== 7">
                {{ blockNumber - 1 }}
            </div>
            <div class="d-block position-absolute w-100 font-weight-regular text-right"
                 style="bottom: -25px"
                 v-else>
                {{ blockNumber - 1 + '+' }}
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
        methods: {
            counters() {
                let count = [];

                // Ищем кол-во карт со стоимостью атрибута равному i
                for (let i = 0; i <= 7; i++) {
                    let counter = 0;
                    if (i === 7) {
                        this.cards.filter(item => item[this.attribute] >= i).forEach(item => {
                            if (item.count === 2)
                                counter += 2;
                            else
                                counter++;
                        });

                        count.push({
                            value: i,
                            count: counter
                        })
                    } else {
                        this.cards.filter(item => item[this.attribute] === i).forEach(item => {
                            if (item.count === 2)
                                counter += 2;
                            else
                                counter++;
                        });

                        count.push({
                            value: i,
                            count: counter
                        })
                    }
                }

                return count;
            },
            setHistogram() {
                let counter = this.counters();

                let max = 0;

                counter.forEach(item => {
                    if (item.count > max) {
                        max = item.count;
                    }
                })

                counter.forEach((item) => {
                    $("#"+ this.attribute + ":nth-child(" + (item.value + 1) + ") .background-histogram").css("height", 100 * (item.count / max) + "%")
                })
            }
        },
        mounted() {
            this.setHistogram();
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
        height: 0;
        bottom: 0;
        left: 0;
    }
</style>