<?php

namespace App\Services\Api\v1\Hearthstone\Races;

use App\Models\Hearthstone\Race;

class RaceService
{
    /**
     * Получаем коллекцию всех рас карт.
     * @return Race[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getRaces()
    {
        return Race::all();
    }
}