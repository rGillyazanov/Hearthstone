<?php

namespace App\Services\Api\v1\Hearthstone\Mechanics;

use App\Models\Hearthstone\Mechanic;

class MechanicService
{
    /**
     * Получаем коллекцию всех маханик карт.
     * @return Mechanic[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMechanics()
    {
        return Mechanic::all();
    }
}