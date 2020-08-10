import VueRouter from "vue-router";
import CardsComponent from "./components/hearthstone/Cards/CardsComponent";
import CardComponent from "./components/hearthstone/Card/CardComponent";
import InformationComponent from "./components/hearthstone/Information/InformationComponent";
import ChoiceHeroesComponent from "./components/hearthstone/DeckBuilder/ChoiceHeroesComponent";
import ChoiceCardsForDeckComponent from "./components/hearthstone/DeckBuilder/ChoiceCardsForDeckComponent";
import DeckComponent from "./components/hearthstone/Deck/DeckComponent";
import Login from "./components/hearthstone/Autorization/Login";
import Registration from "./components/hearthstone/Autorization/Registration";

const router = new VueRouter({
    routes: [
        { path: '/', component: CardsComponent, name: 'Home' },
        { path: '/card/:id', component: CardComponent, name: 'Card' },
        { path: '/information', component: InformationComponent, name: 'Information' },
        { path: '/deckbuilder', component: ChoiceHeroesComponent, name: 'DeckBuilder' },
        { path: '/deckbuilder/hero/:id', component: ChoiceCardsForDeckComponent, name: 'CardsForDeck' },
        { path: '/deck/:code', component: DeckComponent, name: 'Deck' },
        { path: '/login', component: Login, name: 'Login' },
        { path: '/registration', component: Registration, name: 'Registration' },
    ],
    mode: 'history'
});

export default router;