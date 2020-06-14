/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import CardsComponent from "./components/hearthstone/Cards/CardsComponent";
import CardComponent from "./components/hearthstone/Card/CardComponent";
import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate';
import router from "./router";
import config from "./languages/config";

require('./bootstrap');
window.Vue = require('vue');

Vue.prototype.trans = config;
Vue.use(VueRouter);
Vue.use(Vuelidate);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('cards-component', CardsComponent);
Vue.component('card-component', CardComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
