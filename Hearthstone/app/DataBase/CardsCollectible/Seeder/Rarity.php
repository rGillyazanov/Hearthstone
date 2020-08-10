<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Rarity as RarityModel;

class Rarity extends CardsDataFile
{
    /**
     * Заполняет табилцу Rarity всеми качествами, которые доступны в json файле
     */
    public function insert()
    {
        $rarityList = [];

        /**
         * Ищем все качества из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->rarity))
            {
                if (in_array($this->data[$id]->rarity, $rarityList) == false)
                {
                    // Добавляем качество в массив
                    array_push($rarityList, $this->data[$id]->rarity);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($rarityList as $rarity)
        {
            RarityModel::updateOrCreate([
                'name' => $rarity
            ],[
                'name' => $rarity
            ]);
        }
    }
}
