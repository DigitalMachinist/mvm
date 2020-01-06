<?php

use Domain\Users\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'                  => $faker->name,
        'email'                 => $faker->unique()->safeEmail,
        'email_verified_at'     => now(),
        'email_verify_token'    => Str::random(100),
        'password_reset_token' => Str::random(100),
        'password'              => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ];
});
