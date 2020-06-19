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
    public function cardOfHero(CardsOfDecks $request, $id)
    {
        $cardsOfHero = $this->cardsOfDecksService->getCardsOfHero($id)->appends($request->except('page'));

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
        $neutralsCards = $this->cardsOfDecksService->getNeutralsCards()->appends($request->except('page'));

        return $this->sendResponse($neutralsCards, "Карты нейтральные");
    }

    /**
     * Возвращает коллекцию карт героя по мане
     * @param CardsOfDecks $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardsOfCost(CardsOfDecks $request)
    {
        $cardsOfCost = $this->cardsOfDecksService->getCardsOfCost($request->get('cost'), $request->get('hero_id'))->appends($request->except('page'));

        return $this->sendResponse($cardsOfCost, "Карты героя со стоимостью");
    }
}
