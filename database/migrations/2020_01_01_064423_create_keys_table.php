<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeysTable extends Migration
{
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('colour', 6)->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();

            $table
                ->unique([
                    'project_id',
                    'name',
                ]);
        });

        Schema::create('key_room', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('key_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            $table->timestamps();
        });

        Schema::create('key_pathway', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('key_id')->unsigned();
            $table->bigInteger('pathway_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('key_pathway');
        Schema::dropIfExists('key_room');
        Schema::dropIfExists('keys');
    }
}
