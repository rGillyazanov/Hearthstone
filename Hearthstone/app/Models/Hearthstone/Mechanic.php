<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;
}
