<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 512);
            $table->integer('troupe_id')->unsigned();
            $table->integer('director_id')->unsigned();
            $table->string('author');
            $table->timestamps();

            $table->foreign('troupe_id')->references('id')->on('troupes');
            $table->foreign('director_id')->references('id')->on('directors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('plays'))
        {
            Schema::table('plays', function(Blueprint $table) {
                $table->dropforeign(['troupe_id', 'director_id']);
            });
        }
        Schema::dropIfExists('play');
    }
}
