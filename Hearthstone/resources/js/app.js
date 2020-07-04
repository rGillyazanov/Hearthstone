import CardsComponent from "./components/hearthstone/Cards/CardsComponent";
import CardComponent from "./components/hearthstone/Card/CardComponent";
import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate';
import router from "./router";
import config from "./languages/config";
import store from "./store";
import Login from "./components/hearthstone/Autorization/Login";
import Registration from "./components/hearthstone/Autorization/Registration";

require('./bootstrap');
window.Vue = require('vue');

Vue.prototype.trans = config;
Vue.use(VueRouter);
Vue.use(Vuelidate);

Vue.component('cards-component', CardsComponent);
Vue.component('card-component', CardComponent);
Vue.component('login-component', Login);
Vue.component('registration-component', Registration);

const app = new Vue({
    el: '#app',
    store,
    router
});
