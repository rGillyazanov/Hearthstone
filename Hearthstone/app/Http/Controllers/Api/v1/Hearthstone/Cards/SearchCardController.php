<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Cards;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Http\Requests\Heathstone\Cards\SearchCards;
use App\Services\Api\v1\Hearthstone\Cards\CardService;

class SearchCardController extends BaseController
{
    private $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchCards $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchCards $request)
    {
        $cards = $this->cardService->getCardsWithSearchParameters($request->except(['page']))->appends($request->all());

        return $this->sendResponse($cards, "Карты с параметрами поиска");
    }
}
