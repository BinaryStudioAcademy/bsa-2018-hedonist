<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_url');
            $table->string('description');
            $table->unsignedInteger('place_id');
            $table->unsignedInteger('creator_id');
            $table->timestamps();

            $table->foreign('place_id')->references('id')->on('places');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_photos');
    }
}
