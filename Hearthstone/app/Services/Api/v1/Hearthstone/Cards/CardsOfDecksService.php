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
     * Получаем карты героя по id и формату (Вольныйы или стандартный)
     *
     * @param $id
     * @param $format 1 - Вольный , 2 - Стандартный
     * @return mixed
     */
    public function getCardsOfHero($id, $format)
    {
        if ($format == 2)
            return Card::where('hero_id', $id)->standard()->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);

        return Card::where('hero_id', $id)->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);
    }

    /**
     * Получаем коллекцию всех карт для отображения с пагинацией.
     * @param $format 1 - Вольный , 2 - Стандартный
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getNeutralsCards($format)
    {
        if ($format == 2)
            return Card::where('hero_id', 4)->standard()->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);

        return Card::where('hero_id', 4)->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);
    }

    /**
     * Получаем карты по стоимости для указанного героя
     * @param $cost
     * @param $hero_id
     * @param $format 1 - Вольный , 2 - Стандартный
     * @return mixed
     */
    public function getCardsOfCost($cost, $hero_id, $format)
    {
        // Стандартные карты со стоимостью >= 10
        if ($cost == 10 && $format == 2)
            return Card::where('cost', '>=', $cost)->where('hero_id', $hero_id)->standard()->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);
        // Стандартные карты со стоимостью < 10
        else if ($cost < 10 && $format == 2)
            return Card::where('cost', $cost)->where('hero_id', $hero_id)->standard()->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);
        // Вольные карты со стоимостью >= 10
        else if ($cost == 10 && $format == 1)
            return Card::where('cost', '>=', $cost)->where('hero_id', $hero_id)->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);

        // Вольные карты со стоимостью < 10
        return Card::where('cost', $cost)->where('hero_id', $hero_id)->notSkinsAndOrderByCostName()->paginate($this->perPage, $this->select);
    }
}