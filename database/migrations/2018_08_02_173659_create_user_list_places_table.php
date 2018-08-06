<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserListPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_list_places', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('list_id');
            $table->unsignedInteger('place_id');
            $table->foreign('list_id')->references('id')->on('user_lists');
//            $table->foreign('place_id')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_list_places');
    }
}
