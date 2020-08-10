<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class CardTag extends Model
{
    protected $table = 'card_tag';

    protected $fillable = ["card_id", "mechanic_id"];

    public $timestamps = false;

    /**
     * Все теги у карты
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Mechanic::class);
    }
}
