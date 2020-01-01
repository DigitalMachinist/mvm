<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->integer('difficulty')->default(1);
            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->string('colour', 6)->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
