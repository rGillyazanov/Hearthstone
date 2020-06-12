import VueRouter from "vue-router";
import CardsComponent from "./components/hearthstone/Cards/CardsComponent";
import CardComponent from "./components/hearthstone/Card/CardComponent";

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: CardsComponent,
            name: 'Home'
        },
        {
            path: '/card/:id',
            component: CardComponent,
            name: 'Card'
        }
    ],
    mode: 'history'
})