<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = ["name", "playerClass", "user_id", "cost", "code", "created_at", "updated_at"];
}
