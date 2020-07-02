import CardsComponent from "./components/hearthstone/Cards/CardsComponent";
import CardComponent from "./components/hearthstone/Card/CardComponent";
import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate';
import router from "./router";
import config from "./languages/config";
import store from "./store";

require('./bootstrap');
window.Vue = require('vue');

Vue.prototype.trans = config;
Vue.use(VueRouter);
Vue.use(Vuelidate);

Vue.component('cards-component', CardsComponent);
Vue.component('card-component', CardComponent);

const app = new Vue({
    el: '#app',
    store,
    router
});
