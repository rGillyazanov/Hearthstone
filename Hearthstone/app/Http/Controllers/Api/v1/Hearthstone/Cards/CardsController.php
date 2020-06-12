<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Cards;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Services\Api\v1\Hearthstone\Cards\CardService;

class CardsController extends BaseController
{
    private $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Отображает список всех карт.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cards = $this->cardService->getCardsWithPaginate();

        return $this->sendResponse($cards, "Все карты");
    }
}
