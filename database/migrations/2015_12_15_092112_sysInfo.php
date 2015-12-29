<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sysInfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name',60);
            $table->string('value');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('Name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sysInfo');
    }
}
