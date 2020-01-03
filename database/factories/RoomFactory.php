<?php

use Domain\Projects\Project;
use Domain\Rooms\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'project_id'  => fn(): int => factory(Project::class)->create()->id,
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph(3),
        'difficulty'  => $faker->numberBetween(1, 3),
        'x'           => $faker->randomNumber(4),
        'y'           => $faker->randomNumber(4),
        'width'       => $faker->randomNumber(3),
        'height'      => $faker->randomNumber(3),
        'colour'      => ltrim($faker->hexcolor, '#'),
        'image_url'   => $faker->url,
        'created_at'  => now(),
        'updated_at'  => now(),
    ];
});
