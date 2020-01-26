<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailVerification extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
            $table->dropColumn('password');
            $table->dropColumn('remember_token');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->datetime('email_verified_at')->nullable();
            $table->datetime('email_verify_expires_at')->nullable();
            $table->datetime('password_reset_at')->nullable();
            $table->datetime('password_reset_expires_at')->nullable();
            $table->string('email_verify_token')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->string('password');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->index(['email']);
            $table->unique(['email_verify_token']);
            $table->unique(['password_reset_token']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['password_reset_token']);
            $table->dropUnique(['email_verify_token']);
            $table->dropIndex(['email']);
            $table->unique(['email']);

            $table->dropColumn('password_reset_token');
            $table->dropColumn('password_reset_expires_at');
            $table->dropColumn('password_reset_at');
            $table->dropColumn('email_verify_token');
            $table->dropColumn('email_verify_expires_at');
            $table->rememberToken();
        });
    }
}
