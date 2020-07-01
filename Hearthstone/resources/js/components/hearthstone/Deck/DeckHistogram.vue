<template>
    <div data-placement="top"
         data-toggle="tooltip"
         :title="title">
        <div :id="attribute" class="block"
             :style="{'border-color': color}"
             v-for="(blockNumber, index) in histogramData">
            <!-- Блок с количеством карт -->
            <div class="d-block position-absolute w-100 font-weight-regular text-center"
                 style="top: -25px" v-if="blockNumber.count !== 0">
                {{ blockNumber.count }}
            </div>
            <!-- Блок с процентом заполнения карт -->
            <div class="background-histogram"
                 :style="{'background-color': color, 'height': 100 * blockNumber.count / maxAttributeValue + '%'}"></div>
            <!-- Блок со стоимостью карт -->
            <div class="d-block position-absolute w-100 font-weight-regular text-center"
                 style="bottom: -25px"
                 v-if="index !== 7">
                {{ index }}
            </div>
            <div class="d-block position-absolute w-100 font-weight-regular text-right"
                 style="bottom: -25px"
                 v-else>
                {{ index + '+' }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DeckHistogram",
        data() {
            return {
                histogramData: [],
                maxAttributeValue: 0
            }
        },
        props: {
            color: String,
            cards: Array,
            attribute: String,
            title: String
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
            getMaxValueOfHistogram() {
                this.histogramData = this.counters();

                let max = 0;

                this.histogramData.forEach(item => {
                    if (item.count > max) {
                        max = item.count;
                    }
                })

                this.maxAttributeValue = max;
            }
        },
        created() {
            this.getMaxValueOfHistogram();
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