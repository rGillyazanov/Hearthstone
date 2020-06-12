<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Cards\Card;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Services\Api\v1\Hearthstone\Cards\CardService;

class CardController extends BaseController
{
    private $cardService;

    public function __construct(CardService $cardService)
    {
        $this->cardService = $cardService;
    }

    /**
     * Возвращает карту по id
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function index($id)
    {
        $card = $this->cardService->getCard($id);

        if (!$card)
            return abort(404);

        return $this->sendResponse($card, "Карта получена");
    }
}