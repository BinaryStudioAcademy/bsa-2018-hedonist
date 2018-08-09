<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceAndListForeignKeysToUserListPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_list_places', function (Blueprint $table) {
            $table->foreign('list_id')->references('id')->on('user_lists');
            $table->foreign('place_id')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_list_places', function (Blueprint $table) {
            $table->dropForeign(['place_id']);
            $table->dropForeign(['list_id']);
        });
    }
}
