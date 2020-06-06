<?php

namespace Library\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use Library\CardsCollectible\CardsDataFile;

class Rarity extends CardsDataFile
{
    /**
     * Заполняет табилцу Rarity всеми качествами, которые доступны в json файле
     */
    public function insertRarity()
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
        for ($rarityId = 0; $rarityId < count($rarityList); $rarityId++)
        {
            DB::insert('INSERT INTO `rarities`(`name`) VALUES (?)',
                [
                    $rarityList[$rarityId]
                ]
            );
        }
    }
}
