<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_tr', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place_name');
            $table->string('place_description');

            $table->unsignedInteger('place_id');
            $table->unsignedInteger('language_id');

            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('language_id')->references('id')->on('languages');
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
        Schema::dropIfExists('places_tr');
    }
}
