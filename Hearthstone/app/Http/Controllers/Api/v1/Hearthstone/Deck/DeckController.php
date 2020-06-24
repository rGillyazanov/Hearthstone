<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Deck;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Http\Requests\Hearthstone\Deck\DeckImportCards;
use App\Services\Api\v1\Hearthstone\Deck\DeckService;

class DeckController extends BaseController
{
    private $deckService;

    public function __construct(DeckService $deckService)
    {
        $this->deckService = $deckService;
    }

    /**
     * Возвращает коллекцию карт импортированных из кода колоды
     *
     * @param DeckImportCards $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCardsFromCodeDeck(DeckImportCards $request)
    {
        $cards = $this->deckService->getCardsFromCodeDeck($request->get('cardsId'));

        return $this->sendResponse($cards, "Коллекция карт импортированных из кода колоды");
    }
}
