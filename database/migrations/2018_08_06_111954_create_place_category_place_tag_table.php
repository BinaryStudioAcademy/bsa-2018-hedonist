<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceCategoryPlaceTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_category_place_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('place_category_id');
            $table->unsignedInteger('place_tag_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('place_category_id')
                ->references('id')
                ->on('place_categories')
                ->onDelete('cascade');

            $table->foreign('place_tag_id')
                ->references('id')
                ->on('place_categories_tags')
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
        Schema::dropIfExists('place_category_place_tag');
    }
}
