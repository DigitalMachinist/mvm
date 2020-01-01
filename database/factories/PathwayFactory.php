<?php

use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Faker\Generator as Faker;

$factory->define(Pathway::class, function (Faker $faker) {
    return [
        'project_id'  => fn(): int => factory(Project::class)->create()->id,
        'room_1_id'   => fn(): int => factory(Room::class)->create()->id,
        'room_2_id'   => fn(): int => factory(Room::class)->create()->id,
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph(3),
        'difficulty'  => $faker->numberBetween(1, 3),
        'colour'      => ltrim($faker->hexcolor, '#'),
        'image_url'   => $faker->url,
        'created_at'  => now(),
        'updated_at'  => now(),
    ];
});
