<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesPlacesFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places_places_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->unsigned();
            $table->integer('place_feature_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('place_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade');

            $table->foreign('place_feature_id')
                ->references('id')
                ->on('places_features')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places_places_features');
    }
}
