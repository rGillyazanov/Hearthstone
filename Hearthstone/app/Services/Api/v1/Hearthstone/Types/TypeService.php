<?php

namespace App\Services\Api\v1\Hearthstone\Types;

use App\Models\Hearthstone\Type;

class TypeService
{
    /**
     * Получаем коллекцию всех типов карт.
     * @return Type[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTypes()
    {
        return Type::all();
    }
}