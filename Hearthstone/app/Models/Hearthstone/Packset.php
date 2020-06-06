<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Packset extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;
}
