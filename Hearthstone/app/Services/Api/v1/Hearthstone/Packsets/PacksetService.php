<?php

namespace App\Services\Api\v1\Hearthstone\Packsets;

use App\Models\Hearthstone\Packset;

class PacksetService
{
    /**
     * Получаем коллекцию всех наборов карт.
     * @return Packset[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPackSets()
    {
        return Packset::all();
    }
}