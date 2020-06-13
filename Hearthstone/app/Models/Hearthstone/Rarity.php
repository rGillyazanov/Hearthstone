<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;

    /**
     * Получаем все карты с текущим качеством
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
