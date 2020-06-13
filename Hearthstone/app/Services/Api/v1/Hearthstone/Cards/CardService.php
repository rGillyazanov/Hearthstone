<?php

namespace App\Services\Api\v1\Hearthstone\Cards;

use App\Models\Hearthstone\Card;

class CardService
{
    /**
     * Количество карт на страницу
     * @var int
     */
    public $perPage = 12;

    /**
     * Данные, необходимые для отображения карт
     * @var string[]
     */
    public $select = [
        'id_card',
        'cards.id',
        'name'
    ];

    /**
     * Получаем карту с отношениями по id
     * @param $id
     * @return mixed
     */
    public function getCard($id)
    {
        $relations = ['mechanics', 'hero', 'rarity', 'type', 'race', 'packset'];

        return Card::with($relations)->where('id', $id)->first();
    }

    /**
     * Получаем коллекцию всех карт для отображения с пагинацией.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCardsWithPaginate()
    {
        return Card::select($this->select)->paginate($this->perPage);
    }

    /**
     * Получаем коллекцию карт по параметрам поиска
     * @param $parametersSearch
     * @return mixed
     */
    public function getCardsWithSearchParameters($parametersSearch)
    {
        // search - scopeSearch в модели Card
        return Card::select($this->select)->search($parametersSearch)->paginate($this->perPage);
    }

    /**
     * Возвращает коллекцию карт по названию карты
     * @param $cardName
     * @return mixed
     */
    public function getCardsWithNameParameter($cardName)
    {
        return Card::select($this->select)->where('name', 'LIKE', '%'.$cardName.'%')->paginate($this->perPage);
    }
}