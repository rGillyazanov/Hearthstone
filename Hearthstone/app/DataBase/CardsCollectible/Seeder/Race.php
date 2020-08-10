<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Race as RaceModel;

class Race extends CardsDataFile
{
    /**
     * Заполняет табилцу Race всеми рассами, которые доступны в json файле
     */
    public function insert()
    {
        $raceList = [];

        /**
         * Ищем все расы из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->race))
            {
                if (!in_array($this->data[$id]->race, $raceList))
                {
                    // Добавляем расу в массив
                    array_push($raceList, $this->data[$id]->race);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($raceList as $race)
        {
            RaceModel::updateOrCreate([
                'name' => $race
            ],[
                'name' => $race
            ]);
        }
    }
}
