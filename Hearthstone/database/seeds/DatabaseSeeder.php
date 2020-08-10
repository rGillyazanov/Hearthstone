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
        $instances = [
            new \App\DataBase\CardsCollectible\Seeder\Heroes(),
            new \App\DataBase\CardsCollectible\Seeder\Packset(),
            new \App\DataBase\CardsCollectible\Seeder\Race(),
            new \App\DataBase\CardsCollectible\Seeder\Rarity(),
            new \App\DataBase\CardsCollectible\Seeder\Type(),
            new \App\DataBase\CardsCollectible\Seeder\Mechanics(),
            new \App\DataBase\CardsCollectible\Seeder\Tags(),
            new \App\DataBase\CardsCollectible\Seeder\Cards(),
            new \App\DataBase\CardsCollectible\Seeder\MechanicsField(),
            new \App\DataBase\CardsCollectible\Seeder\CardClasses(),
            new \App\DataBase\CardsCollectible\Seeder\CardReferenceTag()
        ];

        foreach ($instances as $instance) {
            $this->call($instance->insert());

            echo get_class($instance)." закончил работу.".PHP_EOL;
        }
    }
}
