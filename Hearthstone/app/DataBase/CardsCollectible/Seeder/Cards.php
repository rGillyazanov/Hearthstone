<?php

namespace App\DataBase\CardsCollectible\Seeder;

use App\DataBase\CardsCollectible\CardsDataFile;
use App\Models\Hearthstone\Card;

class Cards extends CardsDataFile
{
    /**
     * Заполняет таблицу данными из json файла
     */
    public function insertCards()
    {
        /**
         * Проходим по всем записям из json файла и заполняем поля таблицы
         */
        for ($i = 0; $i < count($this->data); $i++)
        {
            Card::create([
                'name' => isset($this->data[$i]->name) ? $this->data[$i]->name : '',
                'collectible' => isset($this->data[$i]->collectible) ? $this->data[$i]->collectible : 0,
                'attack' => isset($this->data[$i]->attack) ? $this->data[$i]->attack : null,
                'health' => isset($this->data[$i]->health) ? $this->data[$i]->health : null,
                'durability' => isset($this->data[$i]->durability) ? $this->data[$i]->durability : null,
                'armor' => isset($this->data[$i]->armor) ? $this->data[$i]->armor : null,
                'cost' => isset($this->data[$i]->cost) ? $this->data[$i]->cost : null,
                'dbfId' => isset($this->data[$i]->dbfId) ? $this->data[$i]->dbfId : null,
                'flavor' => isset($this->data[$i]->flavor) ? $this->data[$i]->flavor : null,
                'id_card' => isset($this->data[$i]->id) ? $this->data[$i]->id : '',
                'hero_id' => $this->checkFieldId('heroes', 'name', strval(isset($this->data[$i]->cardClass) ? $this->data[$i]->cardClass : null)),
                'race_id' => $this->checkFieldId('races', 'name', strval(isset($this->data[$i]->race) ? $this->data[$i]->race : null)),
                'rarity_id' => $this->checkFieldId('rarities', 'name', strval(isset($this->data[$i]->rarity) ? $this->data[$i]->rarity : null)),
                'packset_id' => $this->checkFieldId('packsets', 'name', strval(isset($this->data[$i]->set) ? $this->data[$i]->set : null)),
                'text' => isset($this->data[$i]->text) ? $this->data[$i]->text : null,
                'type_id' => $this->checkFieldId('types', 'name', strval(isset($this->data[$i]->type) ? $this->data[$i]->type : null)),
                'artist' => isset($this->data[$i]->artist) ? $this->data[$i]->artist : null
            ]);
        }
    }
}
