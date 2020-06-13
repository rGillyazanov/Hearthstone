<?php

namespace App\DataBase\CardsCollectible;

use Illuminate\Support\Facades\DB;

abstract class CardsDataFile
{
    /**
     * Путь до json файла со списком карт
     * @var string
     */
    protected $path = "https://api.hearthstonejson.com/v1/48705/ruRU/cards.collectible.json";

    /**
     * Массив данных из json файла
     * @var mixed
     */
    protected $data;

    function __construct()
    {
        $this->data = $this->getData();
    }

    /**
     * Возвращает массив данных из json файла.
     *
     * @return mixed
     */
    private function getData()
    {
        if (empty($this->path)) {
            return null;
        }

        $file = @file_get_contents($this->path);

        return json_decode($file);
    }

    /**
     * Ищет ID записи в таблице
     * @param $table
     * @param $column
     * @param $value
     * @return null
     */
    protected function checkFieldId($table, $column, $value)
    {
        $select = DB::table($table)->select('id')->where($column, "=", $value)->first();

        if (!empty($select->id)) {
            return $select->id;
        }

        return null;
    }
}
