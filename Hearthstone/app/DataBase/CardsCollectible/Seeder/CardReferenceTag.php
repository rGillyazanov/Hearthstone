<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\CardTag;

class CardReferenceTag extends CardsDataFile
{
    /**
     * Заполняет табилцу card_tag.
     * Тэг - это не основная механика карты.
     * Например: Боевой клич: вы кладете у руку существо с натиском (Тэг).
     */
    public function insert()
    {
        for ($i = 0; $i < count($this->data); $i++)
        {
            if (isset($this->data[$i]->referencedTags))
            {
                $cardIdInDB = $this->checkFieldId('cards', 'name', $this->data[$i]->name);

                for ($j = 0; $j < count($this->data[$i]->referencedTags); $j++)
                {
                    /**
                     * Выбираем тэг карты и ищем его ID в базе данных таблицы tags.
                     * После чего создаем новую запись в таблице card_tag
                     */
                    $tag = $this->data[$i]->referencedTags[$j];

                    $tagIdInDB = $this->checkFieldId('tags', 'name', $tag);

                    CardTag::updateOrCreate([
                        'card_id' => $cardIdInDB,
                        'tag_id' => $tagIdInDB
                    ], [
                        'card_id' => $cardIdInDB,
                        'tag_id' => $tagIdInDB
                    ]);
                }
            }
        }
    }
}
