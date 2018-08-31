<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceTastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_tastes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_id');
            $table->unsignedInteger('taste_id');
            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('taste_id')->references('id')->on('tastes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_tastes');
    }
}
