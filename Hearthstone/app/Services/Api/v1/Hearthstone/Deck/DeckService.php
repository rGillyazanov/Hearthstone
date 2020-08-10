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
        'health',
        'type_id'
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
        /**
         * Разбиваем строку состоящую из Id полученных карт типа:
         * [123, 321, 332] в массив.
         */
        $idOfCards = explode(",", str_replace ('[', '', (str_replace (']', '', $cardsIdInDeck))));

        return Card::whereIn('dbfId', $idOfCards)->with('type')->NotSkinsAndOrderByCostName()->orderBy('dbfId')->get($this->select);
    }
}