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

            $query = CardMechanic::select(['cards.id', 'id_card', 'name'])
                ->join('cards', 'cards.id', '=', 'card_mechanic.card_id')
                ->where('mechanic_id', $mechanics_id);

            SearchCardService::queryWhereKeyValue($query, $parameters)->NotSkinsAndOrderByCostName();

            return $query;
        }

        return SearchCardService::queryWhereKeyValue($query, $parameters)->notSkinsAndOrderByCostName();
    }

    /**
     * Возвращает коллекцию карт из стандартного набора
     * @param $query
     * @return mixed
     */
    public function scopeStandard($query)
    {
        // Наборы стандартных карт
        $packSets = [6, 4, 24, 11, 22, 10, 8, 5, 21];

        return $query->whereIn('packset_id', $packSets);
    }

    /**
     * Возвращает коллекцию карт героя.
     *
     * @param $query
     * @param $heroId
     * @return mixed
     */
    public function scopeHeroes($query, $heroId)
    {
        $query->leftJoin('card_hero', 'cards.id', '=', 'card_hero.card_id');

        if ($heroId == 4) {
            $query->where('card_hero.card_id', '=', null);
        }

        return $query->where(function($query) use ($heroId) {
                $query->where('card_hero.hero_id', $heroId)
                    ->orWhere('cards.hero_id', $heroId);
            })
            ->distinct();
    }

    /**
     * Возвращает коллекцию карт без скинов героев и отсортированную
     * по стоимости и названию.
     * @param $query
     * @return mixed
     */
    public function scopeNotSkinsAndOrderByCostName($query)
    {
        return $query->where('cost', '!=', null)->orderBy('cost')->orderBy('name');
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

    /**
     * Получить все теги у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Получить всех героев у текущей карты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function heroes()
    {
        return $this->belongsToMany(Hero::class);
    }
}
