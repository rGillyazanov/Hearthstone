<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Type as TypeModel;

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
                if (!in_array($this->data[$id]->type, $typeList))
                {
                    // Добавляем качество в массив
                    array_push($typeList, $this->data[$id]->type);
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($typeList as $type)
        {
            TypeModel::updateOrCreate([
                'name' => $type
            ],[
                'name' => $type
            ]);
        }
    }
}
