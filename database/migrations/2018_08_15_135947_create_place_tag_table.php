<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('placecategory_placetag_id');
            $table->unsignedInteger('place_id');

            $table->foreign('placecategory_placetag_id')
                ->references('id')
                ->on('place_category_place_tag')
                ->onDelete('cascade');

            $table->foreign('place_id')
                ->references('id')
                ->on('places')
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
        Schema::dropIfExists('place_tag');
    }
}
