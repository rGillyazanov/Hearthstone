<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeckCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deck_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('double');
            $table->bigInteger('card_id')->unsigned()->index();
            $table->bigInteger('deck_id')->unsigned()->index();

            $table->foreign('card_id')->references('id')->on('cards')->onUpdate('cascade');
            $table->foreign('deck_id')->references('id')->on('decks')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deck_cards');
    }
}
