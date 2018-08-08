<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');

            $table->float('longitude');
            $table->float('latitude');
            $table->integer('zip');
            $table->string('address');
            $table->string('phone');
            $table->string('website');

            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('city_id');

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('place_categories');
            $table->foreign('city_id')->references('id')->on('cities');

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
        Schema::dropIfExists('places');
    }
}
