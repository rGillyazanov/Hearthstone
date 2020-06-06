<?php

namespace Library\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use Library\CardsCollectible\CardsDataFile;

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
                    if (in_array($this->data[$i]->mechanics[$j], $mechanics_list) == false)
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
        for ($mechanicId = 0; $mechanicId < count($mechanics_list); $mechanicId++)
        {
            DB::insert('INSERT INTO `mechanics`(`name`) VALUES (?)',
                [
                    $mechanics_list[$mechanicId]
                ]
            );
        }
    }
}