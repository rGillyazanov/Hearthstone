<?php

namespace App\Services\Api\v1\Hearthstone\Deck;

use App\Models\Hearthstone\Card;

class DeckService
{
    private $select = [
        'id_card',
        'cards.id',
        'name',
        'dbfId',
        'rarity_id',
        'cost',
        'attack',
        'health'
    ];

    /**
     * Возвращает коллекцию карт по id, полученным из
     * импорта кода колоды
     *
     * @param $cardsIdInDeck
     * @return mixed
     */
    public function getCardsFromCodeDeck($cardsIdInDeck)
    {
        $idOfCards = explode(",", str_replace ('[', '', (str_replace (']', '', $cardsIdInDeck))));
        return Card::whereIn('dbfId', $idOfCards)->NotSkinsAndOrderByCostName()->orderBy('dbfId')->get($this->select);
    }
}