<?php

namespace Library\CardsCollectible\Seeder;

use App\Card;
use Library\CardsCollectible\CardsDataFile;

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
                'name' => $this->getValueFromJson(isset($this->data[$i]->name) ? $this->data[$i]->name : ""),
                'collectible' => $this->getValueFromJson(isset($this->data[$i]->collectible) ? $this->data[$i]->collectible : 0),
                'attack' => $this->getValueFromJson(isset($this->data[$i]->attack) ? $this->data[$i]->attack : null),
                'health' => $this->getValueFromJson(isset($this->data[$i]->health) ? $this->data[$i]->health : null),
                'durability' => $this->getValueFromJson(isset($this->data[$i]->durability) ? $this->data[$i]->durability : null),
                'armor' => $this->getValueFromJson(isset($this->data[$i]->armor) ? $this->data[$i]->armor : null),
                'cost' => $this->getValueFromJson(isset($this->data[$i]->cost) ? $this->data[$i]->cost : null),
                'dbfId' => $this->getValueFromJson(isset($this->data[$i]->dbfId) ? $this->data[$i]->dbfId : null),
                'flavor' => $this->getValueFromJson(isset($this->data[$i]->flavor) ? $this->data[$i]->flavor : null),
                'id_card' => $this->getValueFromJson(isset($this->data[$i]->id) ? $this->data[$i]->id : ''),
                'playerClass' => $this->getValueFromJson($this->checkFieldId('heroes', 'name', strval(isset($this->data[$i]->cardClass) ? $this->data[$i]->cardClass : null))),
                'race' => $this->getValueFromJson($this->checkFieldId('races', 'name', strval(isset($this->data[$i]->race) ? $this->data[$i]->race : null))),
                'rarity' => $this->getValueFromJson($this->checkFieldId('rarities', 'name', strval(isset($this->data[$i]->rarity) ? $this->data[$i]->rarity : null))),
                'packset' => $this->getValueFromJson($this->checkFieldId('packsets', 'name', strval(isset($this->data[$i]->set) ? $this->data[$i]->set : null))),
                'text' => $this->getValueFromJson(isset($this->data[$i]->text) ? $this->data[$i]->text : null),
                'type' => $this->getValueFromJson($this->checkFieldId('types', 'name', strval(isset($this->data[$i]->type) ? $this->data[$i]->type : null))),
                'artist' => $this->getValueFromJson(isset($this->data[$i]->artist) ? $this->data[$i]->artist : null)
            ]);
        }
    }
}
