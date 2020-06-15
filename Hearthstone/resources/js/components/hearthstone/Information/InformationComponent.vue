<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <details open>
                            <summary class="h5">Механики</summary>
                            <ul class="menu-list pl-0">
                                <a v-for="mechanic in mechanics" :href="'#' + mechanic.name"><li>{{ trans.get('mechanics.' + mechanic.name + '.name') }}</li></a>
                            </ul>
                        </details>
                    </div>
                    <div class="col-8">
                        <div class="information p-3 mb-5">
                            <div v-for="mechanic in mechanics" class="mechanics__info">
                                <h5 :id="mechanic.name">{{ trans.get('mechanics.' + mechanic.name + '.name') }}</h5>
                                <span>{{ trans.get('mechanics.' + mechanic.name + '.description') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InformationComponent",
        data() {
            return {
                mechanics: null
            }
        },
        mounted() {
            axios.get('/api/mechanics').then(response => {
                this.mechanics = response.data.data;
            }).catch(error => {
                console.log(error)
            });
        }
    }
</script>

<style scoped>
    .information {
        background-color: #ffffff;
        border-radius: 5px;
    }

    .mechanics__info:not(:last-child) {
        padding-bottom: 15px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.19);
    }

    .mechanics__info:not(:first-child) {
        margin-top: 15px;
    }

    .menu-list {
        list-style: none;
    }

    details summary::-webkit-details-marker {
        display: none;
    }

    details :focus {
        outline: 0;
    }

    details, summary {
        display: block;
        line-height: 2.25rem;
    }

    details[open] ul {
        animation: opening .7s linear;
    }

    @keyframes opening {
        0%    {opacity: 0;}
        100%  {opacity: 1;}
    }

    details summary:before {
        content: "";
    }

    details[open] summary:before {
        content: "";
    }

    summary {
        font-weight: 500;
    }

    summary:hover {
        cursor: pointer;
    }

    ul > a {
        color: #222222;
    }

    ul > a > li {
        transition: all 0.1s ease;
    }

    ul > a > li:hover {
        margin-left: 6px;
        font-weight: 500;
        cursor: pointer;
    }

    ul > a:hover {
        text-decoration: none;
    }
</style>