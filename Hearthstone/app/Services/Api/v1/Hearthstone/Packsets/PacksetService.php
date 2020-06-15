<?php

namespace App\Services\Api\v1\Hearthstone\Packsets;

use App\Models\Hearthstone\Packset;

class PacksetService
{
    /**
     * Получаем коллекцию всех наборов карт, за исключение скинов героев
     * @return Packset[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPackSets()
    {
        return Packset::where('name', '!=', 'HERO_SKINS')->get();
    }
}