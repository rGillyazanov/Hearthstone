<?php

namespace Library\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use Library\CardsCollectible\CardsDataFile;

class Packset extends CardsDataFile
{
    /**
     * Заполняет табилцу Packset всеми наборами, которые доступны в json файле
     */
    public function insertPackset()
    {
        $packsetList = [];

        /**
         * Ищем все наборы из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->set))
            {
                if (in_array($this->data[$id]->set, $packsetList) == false)
                {
                    // Добавляем набор в массив
                    array_push($packsetList, $this->data[$id]->set);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        for ($packsetId = 0; $packsetId < count($packsetList); $packsetId++)
        {
            DB::insert('INSERT INTO `packsets`(`name`) VALUES (?)',
                [
                    $packsetList[$packsetId]
                ]
            );
        }
    }
}
