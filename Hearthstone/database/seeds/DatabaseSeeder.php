<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Heroes())->insertHeroes());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Packset())->insertPackset());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Race())->insertRace());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Rarity())->insertRarity());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Type())->insertType());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Mechanics())->insertMechanics());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\Cards())->insertCards());
        $this->call((new \App\DataBase\CardsCollectible\Seeder\MechanicsField())->insertMechanicsField());
    }
}
