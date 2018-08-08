<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceWorktimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_worktime', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('place_id');
            $table->string('day_code');
            $table->timestamp('start_time');
            $table->timestamp('end_time');

            $table->foreign('place_id')
                ->references('id')
                ->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_worktime');
    }
}
