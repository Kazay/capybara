<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->integer('play_id')->unsigned();
            $table->timestamps();

            $table->foreign('play_id')->references('id')->on('plays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('performance'))
        {
            Schema::table('performances', function(Blueprint $table) {
                $table->dropforeign('play_id');
            });
        }
        Schema::dropIfExists('performances');
    }
}
