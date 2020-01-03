<?php

use Domain\Keys\Key;
use Domain\Projects\Project;
use Faker\Generator as Faker;

$factory->define(Key::class, function (Faker $faker) {
    return [
        'project_id'  => fn(): int => factory(Project::class)->create()->id,
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph(3),
        'colour'      => ltrim($faker->hexcolor, '#'),
        'image_url'   => $faker->url,
        'created_at'  => now(),
        'updated_at'  => now(),
    ];
});
