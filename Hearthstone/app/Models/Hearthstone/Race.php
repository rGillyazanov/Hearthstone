<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;

    /**
     * Получаем все карты с текущей расой
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
