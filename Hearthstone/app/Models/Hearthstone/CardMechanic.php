<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class CardMechanic extends Model
{
    protected $table = 'card_mechanic';

    protected $fillable = ["card_id", "mechanic_id"];

    public $timestamps = false;

    /**
     * Все карты с механикой
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Все механики у карты
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mechanics()
    {
        return $this->hasMany(Mechanic::class);
    }
}
