<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class CardMechanic extends Model
{
    protected $table = 'card_mechanic';

    protected $fillable = ["card_id", "mechanic_id"];

    public $timestamps = false;

    /**
     * Возвращает коллекцию карт без скинов героев и отсортированную
     * по стоимости и названию.
     * @param $query
     * @return mixed
     */
    public function scopeNotSkinsAndOrderByCostName($query)
    {
        return $query->where('cost', '!=', null)->orderBy('cost')->orderBy('name');
    }

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
