<?php

namespace App\Services\Api\v1\Hearthstone\Heroes;

use App\Models\Hearthstone\Hero;

class HeroService
{
    /**
     * Получаем коллекцию всех героев.
     * @return Hero[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getHeroes()
    {
        return Hero::all();
    }

    /**
     * Возвращает героя по id
     * @param $id
     * @return mixed
     */
    public function getHero($id)
    {
        return Hero::findOrFail($id);
    }
}