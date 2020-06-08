<?php

namespace App\Services\Api\v1\Hearthstone\Rarities;

use App\Models\Hearthstone\Rarity;

class RarityService
{
    /**
     * Получаем коллекцию всех качеств карт.
     * @return Rarity[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRarities()
    {
        return Rarity::all();
    }
}