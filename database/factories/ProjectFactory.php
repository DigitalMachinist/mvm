<?php

use Domain\Projects\Project;
use Domain\Users\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'user_id'       => fn(): int => factory(User::class)->create()->id,
        'start_room_id' => null,
        'is_public'     => $faker->randomElement([true, false]),
        'name'          => $faker->sentence(3),
        'description'   => $faker->paragraph(3),
        'colour'        => ltrim($faker->hexcolor, '#'),
        'image_url'     => $faker->url,
        'created_at'    => now(),
        'updated_at'    => now(),
    ];
});
