<?php

namespace App\Models\Hearthstone;

use App\Services\Api\v1\Hearthstone\Cards\SearchCardService;
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

            $query = CardMechanic::select(['cards.id', 'id_card', 'name'])->join('cards', 'cards.id', '=', 'card_mechanics.card_id')->where('mechanics_id', $mechanics_id);
            SearchCardService::queryWhereKeyValue($query, $parameters);

            return $query;
        }

        return SearchCardService::queryWhereKeyValue($query, $parameters);
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
