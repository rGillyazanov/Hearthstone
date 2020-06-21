<?php

namespace App\Services\Api\v1\Hearthstone\Cards;

abstract class BaseCardService
{
    /**
     * Количество карт на страницу
     * @var int
     */
    protected $perPage = 24;

    /**
     * Данные, необходимые для отображения карт
     * @var string[]
     */
    protected $select = [
        'id_card',
        'cards.id',
        'name'
    ];
}