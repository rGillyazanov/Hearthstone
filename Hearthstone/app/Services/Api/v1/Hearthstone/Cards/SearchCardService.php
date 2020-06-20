<?php

namespace App\Services\Api\v1\Hearthstone\Cards;

use App\Models\Hearthstone\Packset;

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
            else
                $query->where($key, '=', $value, 'and');
        }

        return $query;
    }
}