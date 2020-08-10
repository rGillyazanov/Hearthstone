<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardHeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_hero', function (Blueprint $table) {
            $table->bigInteger('card_id')->unsigned()->index();
            $table->bigInteger('hero_id')->unsigned()->index();

            $table->foreign('card_id')->references('id')->on('cards')->onUpdate('cascade');
            $table->foreign('hero_id')->references('id')->on('heroes')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_class');
    }
}
