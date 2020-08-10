<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_tag', function (Blueprint $table) {
            $table->bigInteger('card_id')->unsigned()->index();
            $table->bigInteger('tag_id')->unsigned()->index();

            $table->foreign('card_id')->references('id')->on('cards')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_tag');
    }
}
