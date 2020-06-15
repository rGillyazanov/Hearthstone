import VueRouter from "vue-router";
import CardsComponent from "./components/hearthstone/Cards/CardsComponent";
import CardComponent from "./components/hearthstone/Card/CardComponent";
import InformationComponent from "./components/hearthstone/Information/InformationComponent";

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
        },
        {
            path: '/information',
            component: InformationComponent,
            name: 'Information'
        }
    ],
    mode: 'history'
})