<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Tag;

class Tags extends CardsDataFile
{
    /**
     * Заполняет табилцу Mechanics всеми механиками карт, которые доступны в json файле
     */
    public function insert()
    {
        $tags_list = [];

        /**
         * Ищем все тэги
         */
        for ($i = 0; $i < count($this->data); $i++)
        {
            if (isset($this->data[$i]->referencedTags))
            {
                for ($j = 0; $j < count($this->data[$i]->referencedTags); $j++)
                {
                    if (!in_array($this->data[$i]->referencedTags[$j], $tags_list))
                    {
                        // Добавляем тег
                        array_push($tags_list, $this->data[$i]->referencedTags[$j]);
                    }
                }
            }
        }

        /**
         * Заполняем таблицу
         */
        foreach ($tags_list as $tag)
        {
            Tag::updateOrCreate([
                'name' => $tag
            ],[
                'name' => $tag
            ]);
        }
    }
}