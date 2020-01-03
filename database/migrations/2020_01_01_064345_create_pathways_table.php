<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathwaysTable extends Migration
{
    public function up()
    {
        Schema::create('pathways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->bigInteger('room_1_id')->unsigned()->nullable();
            $table->bigInteger('room_2_id')->unsigned()->nullable();
            $table->string('name');
            $table->text('description');
            $table->integer('difficulty')->default(1);
            $table->string('colour', 6)->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pathways');
    }
}
