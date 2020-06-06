<?php

namespace Library\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use Library\CardsCollectible\CardsDataFile;

class Race extends CardsDataFile
{
    /**
     * Заполняет табилцу Race всеми рассами, которые доступны в json файле
     */
    public function insertRace()
    {
        $raceList = [];

        /**
         * Ищем все расы из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->race))
            {
                if (in_array($this->data[$id]->race, $raceList) == false)
                {
                    // Добавляем расу в массив
                    array_push($raceList, $this->data[$id]->race);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        for ($raceId = 0; $raceId < count($raceList); $raceId++)
        {
            DB::insert('INSERT INTO `races`(`name`) VALUES (?)',
                [
                    $raceList[$raceId]
                ]
            );
        }
    }
}
