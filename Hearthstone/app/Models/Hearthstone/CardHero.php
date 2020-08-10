<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class CardHero extends Model
{
    protected $table = 'card_hero';

    protected $fillable = ["card_id", "hero_id"];

    public $timestamps = false;

    /**
     * Все герои у карты
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function heroes()
    {
        return $this->hasMany(Hero::class);
    }

    /**
     * Все карты у героя
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
