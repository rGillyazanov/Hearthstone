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
    public function index(CardsOfDecks $request, $id)
    {
        $cardsOfHero = $this->cardsOfDecksService->getCardsOfHero($id)->appends($request->except('page'));
        $neutralsCards = $this->cardsOfDecksService->getNeutralsCards()->appends($request->except('page'));

        $cards = ['cardsOfHero' => $cardsOfHero, 'neutralsCards' => $neutralsCards];

        return $this->sendResponse($cards, "Карты героя и нейтральные");
    }
}
