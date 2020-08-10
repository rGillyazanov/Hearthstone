<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link class="navbar-brand" :to="{name: 'Home'}">
                    <img src="/images/logo.png" height="40" alt="Логотип">
                </router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse font-weight-regular" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-3 mr-auto">
                        <router-link tag="li" class="nav-item" :to="{name: 'DeckBuilder'}">
                            <a class="nav-link">Создание колоды</a>
                        </router-link>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Информация
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" :to="{name: 'Information'}">
                                    Механики
                                </router-link>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            <transition name="slide-fade" mode="out-in">
                <keep-alive :exclude="[
                    'CardComponent',
                    'ChoiceCardsForDeckComponent',
                    'ChoiceHeroesComponent',
                    'DeckComponent',
                    'Login',
                    'Registration'
                ]">
                    <router-view></router-view>
                </keep-alive>
            </transition>
        </main>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>