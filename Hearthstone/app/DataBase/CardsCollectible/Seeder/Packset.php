<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Packset as PackSetModel;

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
                if (!in_array($this->data[$id]->set, $packsetList))
                {
                    // Добавляем набор в массив
                    array_push($packsetList, $this->data[$id]->set);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($packsetList as $packSet)
        {
            PackSetModel::create([
                'name' => $packSet
            ]);
        }
    }
}
