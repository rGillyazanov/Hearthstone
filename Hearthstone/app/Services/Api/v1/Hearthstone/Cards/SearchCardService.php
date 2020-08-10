<?php

namespace App\Services\Api\v1\Hearthstone\Cards;

class SearchCardService
{
    /**
     * В запрос добавляется условие Where, где слобцы это ключи массива
     * параметров, а значения поиска - значения массива.
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public static function queryWhereKeyValue($query, $parameters)
    {

        foreach ($parameters as $key => $value) {
            // Если значение маны, атаки или здоровья равно 10, берем карты значение которых больше 10
            if (($key == 'cost' || $key == 'attack' || $key == 'health') && $value == 10)
                $query->where($key, '>=', $value, 'and');
            // При использовании сортировки добавляем в запрос тип сортировки
            else if ($key == 'sort') {
                $value = json_decode($value);
                $query->orderBy($value->name, $value->type);
            }
            else if ($key != 'hero_id')
                $query->where('cards.'.$key, '=', $value, 'and');
        }

        /**
         * Подключается таблица card_hero, для того, чтобы при поиске карт также
         * выводились карты, которые принадлежат нескольким героям.
         */
        if (isset($parameters['hero_id'])) {
            return $query->leftJoin('card_hero', 'cards.id', '=', 'card_hero.card_id')
                ->where(function($query) use ($parameters) {
                        $query->where('card_hero.hero_id', $parameters['hero_id'])
                            ->orWhere('cards.hero_id', $parameters['hero_id']);
                })
                ->distinct();
        }

        return $query;
    }
}