<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('lesson_tag', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('lesson_id')->unsigned();
//            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
//            $table->integer('tag_id')->unsigned();
//            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_tag');
    }
}
