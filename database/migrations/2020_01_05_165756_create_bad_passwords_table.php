<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadPasswordsTable extends Migration
{
    public function up()
    {
        Schema::create('bad_passwords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('password')->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bad_passwords');
    }
}
