<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Mechanic;

class Mechanics extends CardsDataFile
{
    /**
     * Заполняет табилцу Mechanics всеми механиками карт, которые доступны в json файле
     */
    public function insertMechanics()
    {
        $mechanics_list = [];

        /**
         * Ищем все механики карт
         */
        for ($i = 0; $i < count($this->data); $i++)
        {
            if (isset($this->data[$i]->mechanics))
            {
                for ($j = 0; $j < count($this->data[$i]->mechanics); $j++)
                {
                    if (!in_array($this->data[$i]->mechanics[$j], $mechanics_list))
                    {
                        // Добавляем механику
                        array_push($mechanics_list, $this->data[$i]->mechanics[$j]);
                    }
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($mechanics_list as $mechanics)
        {
            Mechanic::create([
                'name' => $mechanics
            ]);
        }
    }
}