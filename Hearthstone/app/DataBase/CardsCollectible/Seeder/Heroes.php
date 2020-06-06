<?php

namespace App\DataBase\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use App\DataBase\CardsCollectible\CardsDataFile;

class Heroes extends CardsDataFile
{
    /**
     * Заполняет табилцу Heroes всеми героями, которые доступны в json файле
     */
    public function insertHeroes()
    {
        $heroesList = [];

        /**
         * Ищем всех героев из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->cardClass))
            {
                if (in_array($this->data[$id]->cardClass, $heroesList) == false)
                {
                    // Добавляем героев в массив
                    array_push($heroesList, $this->data[$id]->cardClass);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        for ($heroesId = 0; $heroesId < count($heroesList); $heroesId++)
        {
            DB::insert('INSERT INTO `heroes`(`name`) VALUES (?)',
                [
                    $heroesList[$heroesId]
                ]
            );
        }
    }
}