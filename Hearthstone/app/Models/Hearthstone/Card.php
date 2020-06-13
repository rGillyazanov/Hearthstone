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

            $query = CardMechanic::select(['cards.id', 'id_card', 'name'])->join('cards', 'cards.id', '=', 'card_mechanic.card_id')->where('mechanic_id', $mechanics_id);
            SearchCardService::queryWhereKeyValue($query, $parameters);

            return $query;
        }

        return SearchCardService::queryWhereKeyValue($query, $parameters);
    }

    /**
     * Получить модель качества у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    /**
     * Получить модель расы у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Получить модель типа у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Получить модель набора у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packset()
    {
        return $this->belongsTo(Packset::class);
    }

    /**
     * Получить модель героя у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hero()
    {
        return $this->belongsTo(Hero::class);
    }

    /**
     * Получить все механики у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mechanics()
    {
        return $this->belongsToMany(Mechanic::class);
    }
}
