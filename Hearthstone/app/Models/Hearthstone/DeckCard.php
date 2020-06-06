<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class DeckCard extends Model
{
    protected $fillable = ["card_id", "deck_id", "double"];

    public $timestamps = false;
}
