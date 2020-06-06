<?php

namespace Library\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use Library\CardsCollectible\CardsDataFile;

class Type extends CardsDataFile
{
    /**
     * Заполняет табилцу Type всеми типами карт, которые доступны в json файле
     */
    public function insertType()
    {
        $typeList = [];

        /**
         * Ищем все типы карт из всех данных
         */
        for ($id = 0; $id < count($this->data); $id++)
        {
            if (isset($this->data[$id]->type))
            {
                if (in_array($this->data[$id]->type, $typeList) == false)
                {
                    // Добавляем качество в массив
                    array_push($typeList, $this->data[$id]->type);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        for ($typeId = 0; $typeId < count($typeList); $typeId++)
        {
            DB::insert('INSERT INTO `types`(`name`) VALUES (?)',
                [
                    $typeList[$typeId]
                ]
            );
        }
    }
}
