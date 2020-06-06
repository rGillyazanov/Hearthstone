<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;
}
