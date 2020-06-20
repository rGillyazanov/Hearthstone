<?php

namespace App\Services\Api\v1\Hearthstone\Cards;

use App\Models\Hearthstone\Card;

class CardService extends BaseCardService
{
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
        return Card::select($this->select)->notSkinsAndOrderByCostName()->paginate($this->perPage);
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
     * Возвращает коллекцию карт по названию или описанию карты
     * @param $cardName
     * @return mixed
     */
    public function getCardsWithNameParameter($cardName)
    {
        return Card::select($this->select)->notSkinsAndOrderByCostName()->where('name', 'LIKE', '%'.$cardName.'%')->
                where('text', 'LIKE', '%'.$cardName.'%', 'or')->paginate($this->perPage);
    }
}