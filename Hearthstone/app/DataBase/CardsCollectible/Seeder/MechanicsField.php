<?php

namespace Library\CardsCollectible\Seeder;

use Illuminate\Support\Facades\DB;
use Library\CardsCollectible\CardsDataFile;

class MechanicsField extends CardsDataFile
{
    /**
     * Заполняет табилцу MechanicsField всеми механиками карт, которые доступны в json файле
     */
    public function insertMechanicsField()
    {
        /**
         * Ищем все механики карт
         */
        for ($i = 0; $i < count($this->data); $i++)
        {
            $cardIdInDB = $this->checkFieldId('cards', 'name', $this->data[$i]->name);

            if (isset($this->data[$i]->mechanics))
            {
                for ($j = 0; $j < count($this->data[$i]->mechanics); $j++)
                {
                    /**
                     * Выбираем механику карты и ищем её ID в базе данных таблицы mechanics,
                     * затем ищем ID карты в таблице cards. После чего создаем новую запись в
                     * таблице mechanics_field
                     */
                    $mechanics = $this->data[$i]->mechanics[$j];

                    $mechanicIdInDB = $this->checkFieldId('mechanics', 'name', $mechanics);

                    DB::insert('INSERT INTO `card_mechanics`(`card_id`, `mechanics_id`) VALUES (?,?)',
                        [
                            $cardIdInDB, $mechanicIdInDB
                        ]
                    );
                }
            }
        }
    }
}
