<template>
    <div>
        <div class="form-group search-form-fields">
            <card-search-name-component v-model.lazy="searchFields.cardName" @input="searchCardsOfName">
                <span slot="label">Поиск по названию и описанию карты</span>
            </card-search-name-component>
            <select-search-form-component
                    v-model.number="searchFields.heroes"
                    :api-link="apiLinks.heroes"
                    placeholder="Герои"
            >
                Герои
            </select-search-form-component>
            <select-search-form-component
                    v-model.number="searchFields.rarities"
                    :api-link="apiLinks.rarities"
                    placeholder="Качество карт"
            >
                Качество карт
            </select-search-form-component>
            <select-search-form-component
                    v-model.number="searchFields.types"
                    :api-link="apiLinks.types"
                    placeholder="Типы карт"
            >
                Типы карт
            </select-search-form-component>
            <select-search-form-component
                    v-model.number="searchFields.races"
                    :api-link="apiLinks.races"
                    placeholder="Расы карт"
            >
                Расы карт
            </select-search-form-component>
            <select-search-form-component
                    v-model.number="searchFields.mechanics"
                    :api-link="apiLinks.mechanics"
                    placeholder="Механики карт"
            >
                Механики карт
            </select-search-form-component>
            <select-search-form-component
                    v-model.number="searchFields.packSets"
                    :api-link="apiLinks.packSets"
                    placeholder="Наборы карт"
            >
                Наборы карт
            </select-search-form-component>
            <div class="select-field">
                <label class="font-weight-regular">Сортировать</label>
                <v-select
                        v-model.number="searchFields.sortBy.value"
                        :options="searchFields.sortBy.options"
                        placeholder="Сортировать"
                        :reduce="label => label.field"
                ></v-select>
            </div>
        </div>
        <div class="form-group border-mana-attack-health mt-3">
            <span class="font-weight-regular">Поиск по атрибутам</span>
            <attribute-card-search-form-component
                    v-model.number="searchFields.attributes.mana"
                    :checked="searchFields.attributes.manaCheckbox"
                    @change="searchFields.attributes.manaCheckbox = $event"
            >
                <span slot="name-attribute">Мана</span>
                <span slot="search-attribute">Поиск по мане</span>
            </attribute-card-search-form-component>
            <attribute-card-search-form-component
                    v-model.number="searchFields.attributes.attack"
                    :checked="searchFields.attributes.attackCheckbox"
                    @change="searchFields.attributes.attackCheckbox = $event"
            >
                <span slot="name-attribute">Атака</span>
                <span slot="search-attribute">Поиск по атаке</span>
            </attribute-card-search-form-component>
            <attribute-card-search-form-component
                    v-model.number="searchFields.attributes.health"
                    :checked="searchFields.attributes.healthCheckbox"
                    @change="searchFields.attributes.healthCheckbox = $event"
            >
                <span slot="name-attribute">Здоровье</span>
                <span slot="search-attribute">Поиск по здоровью</span>
            </attribute-card-search-form-component>
        </div>
        <button type="submit" class="btn btn-success btn-block" @click="searchCards">Найти</button>
    </div>
</template>

<script>
    import CardSearchNameComponent from "./CardsSearchFormComponents/CardSearchNameComponent";
    import SelectSearchFormComponent from "./CardsSearchFormComponents/SelectSearchFormComponent";
    import AttributeCardSearchFormComponent from "./CardsSearchFormComponents/AttributeCardSearchFormComponent";
    import vSelect from 'vue-select';

    export default {
        data() {
            return {
                searchFields: {
                    cardName: "",
                    heroes: null,
                    rarities: null,
                    types: null,
                    races: null,
                    mechanics: null,
                    packSets: null,
                    attributes: {
                        mana: 5,
                        manaCheckbox: false,
                        attack: 5,
                        attackCheckbox: false,
                        health: 5,
                        healthCheckbox: false,
                    },
                    sortBy: {
                        value: null,
                        options: [
                            {
                                label: 'Атаке: по возрастанию',
                                field: {
                                    type: 'asc',
                                    name: 'attack'
                                }
                            },
                            {
                                label: 'Атака: по убыванию',
                                field: {
                                    type: 'desc',
                                    name: 'attack'
                                }
                            },
                            {
                                label: 'Здоровье: по возрастанию',
                                field: {
                                    type: 'asc',
                                    name: 'health'
                                }
                            },
                            {
                                label: 'Здоровье: по убыванию',
                                field: {
                                    type: 'desc',
                                    name: 'health'
                                }
                            },
                            {
                                label: 'Мана: по возрастанию',
                                field: {
                                    type: 'asc',
                                    name: 'cost'
                                }
                            },
                            {
                                label: 'Мана: по убыванию',
                                field: {
                                    type: 'desc',
                                    name: 'cost'
                                }
                            }
                        ]
                    }
                },
                apiLinks: {
                    heroes: '/api/heroes',
                    rarities: '/api/rarities',
                    types: '/api/types',
                    races: '/api/races',
                    mechanics: '/api/mechanics',
                    packSets: '/api/packsets',
                }
            }
        },
        components: {
            AttributeCardSearchFormComponent,
            CardSearchNameComponent,
            SelectSearchFormComponent,
            vSelect
        },
        methods: {
            searchCards() {
                axios.get('/api/cards/search', {
                    params: {
                        hero_id: this.searchFields.heroes,
                        rarity_id: this.searchFields.rarities,
                        type_id: this.searchFields.types,
                        race_id: this.searchFields.races,
                        packset_id: this.searchFields.packSets,
                        cost: this.searchFields.attributes.manaCheckbox ? this.searchFields.attributes.mana : null,
                        attack: this.searchFields.attributes.attackCheckbox ? this.searchFields.attributes.attack : null,
                        health: this.searchFields.attributes.healthCheckbox ? this.searchFields.attributes.health : null,
                        mechanics: this.searchFields.mechanics,
                        sort: this.searchFields.sortBy.value
                    }
                }).then(response => {
                    this.$emit("getSearchResult", response.data);
                }).catch(error => {
                    console.log(error.response.data.errors);
                });
            },
            searchCardsOfName() {
                axios.get('/api/cards/search/name', {
                    params: {
                        name: this.searchFields.cardName
                    }
                }).then(response => {
                    this.$emit("getSearchResult", response.data);
                }).catch(error => {
                    console.log(error.response.data.errors);
                });
            }
        }
    }
</script>

<style scoped>
    .search-form-fields .select-field:not(:first-child) {
        margin-top: 15px;
    }
</style>
