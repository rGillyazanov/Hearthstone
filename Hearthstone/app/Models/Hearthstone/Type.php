<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;
}
