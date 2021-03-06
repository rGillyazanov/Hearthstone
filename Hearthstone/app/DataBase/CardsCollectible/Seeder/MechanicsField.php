<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\CardMechanic;

class MechanicsField extends CardsDataFile
{
    /**
     * Заполняет табилцу card_mechanics всеми механиками карт, которые доступны в json файле
     */
    public function insert()
    {
        /**
         * Ищем все механики карт
         */
        for ($i = 0; $i < count($this->data); $i++)
        {
            if (isset($this->data[$i]->mechanics))
            {
                $cardIdInDB = $this->checkFieldId('cards', 'name', $this->data[$i]->name);

                for ($j = 0; $j < count($this->data[$i]->mechanics); $j++)
                {
                    /**
                     * Выбираем механику карты и ищем её ID в базе данных таблицы mechanics,
                     * затем ищем ID карты в таблице cards. После чего создаем новую запись в
                     * таблице mechanics_field
                     */
                    $mechanics = $this->data[$i]->mechanics[$j];

                    $mechanicIdInDB = $this->checkFieldId('mechanics', 'name', $mechanics);

                    CardMechanic::updateOrCreate([
                        'card_id' => $cardIdInDB,
                        'mechanic_id' => $mechanicIdInDB
                    ], [
                        'card_id' => $cardIdInDB,
                        'mechanic_id' => $mechanicIdInDB
                    ]);
                }
            }
        }
    }
}
