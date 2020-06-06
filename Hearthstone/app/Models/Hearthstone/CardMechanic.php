<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class CardMechanic extends Model
{
    protected $fillable = ["card_id", "mechanics_id"];

    public $timestamps = false;

    public function card()
    {
        return $this->belongsTo(Card::class, "card_id");
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, "mechanics_id");
    }
}
