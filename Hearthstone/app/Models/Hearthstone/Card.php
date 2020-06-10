<?php

namespace App\Models\Hearthstone;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['*'];

    public $timestamps = false;

    /**
     * Возвращает коллекцию найденных карт по параметрам поиска.
     * @param $query
     * @param $parameters
     * @return mixed
     */
    public function scopeSearch($query, $parameters)
    {
        /*
         * Если в параметрах поиска передается id механики карты,
         * тогда возвращаем карты также с выбранной механикой.
         */
        if (isset($parameters['mechanics'])) {
            $mechanics_id = $parameters['mechanics'];
            unset($parameters['mechanics']);

            $query = CardMechanic::select(['id', 'id_card', 'name'])->join('cards', 'cards.id', '=', 'card_mechanics.card_id')->where('mechanics_id', $mechanics_id);
            $this->queryWhereKeyValue($query, $parameters)->where('playerClass', '!=', 4);

            return $query;
        }

        return $this->queryWhereKeyValue($query, $parameters)->where('playerClass', '!=', 4);
    }

    /**
     * В запрос добавляется условие Where, где слобцы это ключи массива
     * параметров, а значения поиска - значения массива.
     * @param $query
     * @param $parameters
     * @return mixed
     */
    private function queryWhereKeyValue($query, $parameters)
    {
        foreach ($parameters as $key => $value)
            $query->where($key, '=', $value, 'and');

        return $query;
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class, "rarity");
    }

    public function race()
    {
        return $this->belongsTo(Race::class, "race");
    }

    public function type()
    {
        return $this->belongsTo(Type::class, "type");
    }

    public function packset()
    {
        return $this->belongsTo(Packset::class, "packset");
    }

    public function hero()
    {
        return $this->belongsTo(Hero::class, "playerClass");
    }

    public function mechanics()
    {
        return $this->belongsToMany(CardMechanic::class, 'card_mechanics', 'mechanics_id', 'card_id');
    }
}
