<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('heading',200);
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('description',1000);
            $table->integer('seen')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('likes')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('can_comment')->default(1);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
