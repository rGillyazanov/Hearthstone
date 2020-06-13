<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Packset extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;

    /**
     * Получаем все карты с текущем набором
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
