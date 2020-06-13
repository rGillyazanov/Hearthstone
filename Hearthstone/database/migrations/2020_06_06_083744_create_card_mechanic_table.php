<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardMechanicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_mechanic', function (Blueprint $table) {
            $table->bigInteger('card_id')->unsigned()->index()->nullable(false);
            $table->bigInteger('mechanic_id')->unsigned()->index()->nullable(false);

            $table->foreign('card_id')->references('id')->on('cards')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('mechanic_id')->references('id')->on('mechanics')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_mechanics');
    }
}
