<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformanceUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('performance_id')->unsigned();

            $table->primary(['user_id', 'performance_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('performance_id')->references('id')->on('performances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('performance_user'))
        {    
            Schema::table('performance_user', function(Blueprint $table) {
                $table->dropForeign(['user_id', 'performance_id']);
            });
        }
        Schema::dropIfExists('performance_user');
    }
}
