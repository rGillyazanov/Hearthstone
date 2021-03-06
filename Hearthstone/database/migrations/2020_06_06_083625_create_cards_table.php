<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->boolean('collectible');
            $table->smallInteger('attack')->nullable();
            $table->smallInteger('health')->unsigned()->nullable();
            $table->smallInteger('durability')->unsigned()->nullable();
            $table->smallInteger('armor')->unsigned()->nullable();
            $table->smallInteger('cost')->unsigned()->nullable();
            $table->unsignedInteger('dbfId')->nullable();
            $table->string('flavor')->nullable();
            $table->string('id_card');
            $table->bigInteger('hero_id')->unsigned()->index()->nullable();
            $table->bigInteger('race_id')->unsigned()->index()->nullable();
            $table->bigInteger('rarity_id')->unsigned()->index()->nullable();
            $table->bigInteger('packset_id')->unsigned()->index()->nullable();
            $table->string('text')->nullable();
            $table->bigInteger('type_id')->unsigned()->index()->nullable();
            $table->string('artist')->nullable();

            $table->foreign('hero_id')->references('id')->on('heroes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('race_id')->references('id')->on('races')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rarity_id')->references('id')->on('rarities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('packset_id')->references('id')->on('packsets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
