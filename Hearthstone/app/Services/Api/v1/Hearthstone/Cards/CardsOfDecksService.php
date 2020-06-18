<?php

namespace App\Services\Api\v1\Hearthstone\Cards;

use App\Models\Hearthstone\Card;

class CardsOfDecksService extends BaseCardService
{
    protected $perPage = 24;

    protected $select = [
        'id_card',
        'cards.id',
        'name',
        'dbfId',
        'rarity_id',
        'cost'
    ];

    /**
     * Получаем карты героя по id
     * @param $id
     * @return mixed
     */
    public function getCardsOfHero($id)
    {
        return Card::where('hero_id', $id)->where('cost', '!=', null)->orderBy('cost')->paginate($this->perPage, $this->select);
    }

    /**
     * Получаем коллекцию всех карт для отображения с пагинацией.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getNeutralsCards()
    {
        return Card::where('hero_id', 4)->where('cost', '!=', null)->orderBy('cost')->paginate($this->perPage, $this->select);
    }
}