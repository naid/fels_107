<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LessonWord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_word', function (Blueprint $table) {
            $table->increments('id');
            $table -> integer('lesson_id')->unsigned();
            $table->foreign('lesson_id')
                    ->references('id')->on('lessons')
                    ->onDelete('cascade');
            $table -> integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->integer('word_id')->unsigned();
            $table->foreign('word_id')
                    ->references('id')->on('words')
                    ->onDelete('cascade');
            $table->string('answer');
            $table->enum('result', ['0','1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lesson_word');
    }
}
