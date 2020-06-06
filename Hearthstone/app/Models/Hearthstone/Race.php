<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;
}
