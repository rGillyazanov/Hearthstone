<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Cards;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Http\Requests\Hearthstone\Cards\CardsOfDecks;
use App\Services\Api\v1\Hearthstone\Cards\CardsOfDecksService;

class CardsOfDecksController extends BaseController
{
    private $cardsOfDecksService;

    public function __construct(CardsOfDecksService $cardsOfDecksService)
    {
        $this->cardsOfDecksService = $cardsOfDecksService;
    }

    /**
     * Возвращает коллекцию карт героя и нейтральных.
     *
     * @param CardsOfDecks $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardsOfHero(CardsOfDecks $request, $id)
    {
        $format = $request->get('format'); // Формат колоды (Вольный или стандартный)
        $cardsOfHero = $this->cardsOfDecksService->getCardsOfHero($id, $format)->appends($request->except('page'));

        return $this->sendResponse($cardsOfHero, "Карты героя");
    }

    /**
     * Возвращает коллекцию нейтральных карт
     *
     * @param CardsOfDecks $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardsNeutrals(CardsOfDecks $request)
    {
        $format = $request->get('format'); // Формат колоды (Вольный или стандартный)
        $neutralsCards = $this->cardsOfDecksService->getNeutralsCards($format)->appends($request->except('page'));

        return $this->sendResponse($neutralsCards, "Карты нейтральные");
    }

    /**
     * Возвращает коллекцию карт героя по мане
     * @param CardsOfDecks $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardsOfCost(CardsOfDecks $request)
    {
        $cost = $request->get('cost'); // Стоимость карт
        $hero = $request->get('hero_id'); // Герой
        $format = $request->get('format'); // Формат колоды (Вольный или стандартный);

        $cardsOfCost = $this->cardsOfDecksService->getCardsOfCost($cost, $hero, $format)->appends($request->except('page'));

        return $this->sendResponse($cardsOfCost, "Карты героя со стоимостью");
    }
}
