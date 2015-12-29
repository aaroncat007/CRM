<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Forum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //分類表
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_categories')->unsigned()->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->softDeletes(); //軟刪除
            $table->timestamp('deactivate')->nullable(); //停用
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        //主題
        Schema::create('posts',function(Blueprint $table){
            $table->increments('id');
            $table->integer('categories_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longText('content')->nullable();
            $table->softDeletes(); //軟刪除
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        //回覆
        Schema::create('posts_reply',function(Blueprint $table){
            $table->increments('id');
            $table->integer('posts_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longText('content')->nullable();
            $table->softDeletes(); //軟刪除
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        //已讀
        Schema::create('posts_read',function(Blueprint $table){
            $table->increments('id');
            $table->integer('reply_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        //紀錄
        Schema::create('record',function(Blueprint $table){
            $table->increments('id');
            $table->integer('categories_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('title');
            $table->longText('content')->nullable();
            $table->softDeletes(); //軟刪除           
            $table->timestamps();

            $table->engine = 'InnoDB';

        });

        //分類授權表
        Schema::create('categories_auth',function(Blueprint $table){
            $table->increments('id');
            $table->integer('categories_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('permissions')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
        Schema::drop('posts');
        Schema::drop('posts_reply');
        Schema::drop('posts_read');
        Schema::drop('record');
        Schema::drop('categories_auth');
    }
}
