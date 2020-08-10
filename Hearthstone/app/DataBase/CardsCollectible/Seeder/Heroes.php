<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\Models\Hearthstone\Hero;
use App\DataBase\CardsCollectible\CardsDataFile;

class Heroes extends CardsDataFile
{
    /**
     * Заполняет табилцу Heroes всеми героями, которые доступны в json файле
     */
    public function insert()
    {
        $heroesList = [];

        /**
         * Ищем всех героев из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->cardClass))
            {
                if (!in_array($this->data[$id]->cardClass, $heroesList))
                {
                    // Добавляем героев в массив
                    array_push($heroesList, $this->data[$id]->cardClass);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($heroesList as $hero)
        {
            Hero::updateOrCreate([
                'name' => $hero
            ],[
                'name' => $hero
            ]);
        }
    }
}