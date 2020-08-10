<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ["name"];

    public $timestamps = false;

    /**
     * Получить все карты с текущим тэгом
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
}
