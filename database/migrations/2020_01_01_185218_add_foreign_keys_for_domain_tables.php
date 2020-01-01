<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysForDomainTables extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table
                ->foreign('start_room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('SET NULL');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('CASCADE');
        });

        Schema::table('pathways', function (Blueprint $table) {
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('CASCADE');

            $table
                ->foreign('room_1_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('SET NULL');

            $table
                ->foreign('room_2_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('SET NULL');
        });

        Schema::table('keys', function (Blueprint $table) {
            $table
                ->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('CASCADE');
        });

        Schema::table('key_pathway', function (Blueprint $table) {
            $table
                ->foreign('key_id')
                ->references('id')
                ->on('keys')
                ->onDelete('CASCADE');

            $table
                ->foreign('pathway_id')
                ->references('id')
                ->on('pathways')
                ->onDelete('CASCADE');
        });

        Schema::table('key_room', function (Blueprint $table) {
            $table
                ->foreign('key_id')
                ->references('id')
                ->on('keys')
                ->onDelete('CASCADE');

            $table
                ->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::table('key_room', function (Blueprint $table) {
            $table->dropForeign(['key_id']);
            $table->dropForeign(['room_id']);
        });

        Schema::table('key_pathway', function (Blueprint $table) {
            $table->dropForeign(['key_id']);
            $table->dropForeign(['pathway_id']);
        });

        Schema::table('keys', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });

        Schema::table('pathways', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['room_1_id']);
            $table->dropForeign(['room_2_id']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['start_room_id']);
        });
    }
}
