<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Cards;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Http\Requests\Hearthstone\Cards\SearchCards;
use App\Http\Requests\Hearthstone\Cards\SearchCardsOfName;
use App\Services\Api\v1\Hearthstone\Cards\CardService;

class SearchCardController extends BaseController
{
    private $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Осуществляет поиск карт по параметрам поиска.
     *
     * @param SearchCards $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchCards $request)
    {
        $cards = $this->cardService->getCardsWithSearchParameters($request->except(['page']))->appends($request->all());

        return $this->sendResponse($cards, "Карты с параметрами поиска");
    }

    /**
     * Осуществляет поиск по названию карты
     * @param SearchCardsOfName $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchOfName(SearchCardsOfName $request)
    {
        $cards = $this->cardService->getCardsWithNameParameter($request->get('name'))->appends($request->only('name'));

        return $this->sendResponse($cards, "Карты найденные по имени");
    }
}
