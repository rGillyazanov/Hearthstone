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
        'id',
        'name'
    ];

    /**
     * Получаем коллекцию всех карт для отображения с пагинацией.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCardsWithPaginate()
    {
        return Card::query()->select($this->select)->paginate($this->perPage);
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
}