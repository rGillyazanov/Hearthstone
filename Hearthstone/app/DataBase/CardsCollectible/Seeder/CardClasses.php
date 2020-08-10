<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\CardHero;

class CardClasses extends CardsDataFile
{
    /**
     * Заполняет табилцу card_hero.
     * Заполняется для карт которые относятся к нескольким героям.
     */
    public function insert()
    {
        for ($i = 0; $i < count($this->data); $i++)
        {
            /**
             * Проходимся по картам и ищем те, которые относятся к нескольким героям.
             */
            if (isset($this->data[$i]->classes))
            {
                $cardIdInDB = $this->checkFieldId('cards', 'name', $this->data[$i]->name);

                for ($j = 0; $j < count($this->data[$i]->classes); $j++)
                {
                    /**
                     * Выбираем класс карты и ищем его ID в базе данных таблицы heroes,
                     * затем ищем ID героя в таблице heroes. После чего создаем новую запись в
                     * таблице card_hero
                     */
                    $hero = $this->data[$i]->classes[$j];

                    $heroIdInDB = $this->checkFieldId('heroes', 'name', $hero);

                    CardHero::updateOrCreate([
                        'card_id' => $cardIdInDB,
                        'hero_id' => $heroIdInDB
                    ], [
                        'card_id' => $cardIdInDB,
                        'hero_id' => $heroIdInDB
                    ]);
                }
            }
        }
    }
}
