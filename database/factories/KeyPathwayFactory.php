<?php

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Faker\Generator as Faker;

$factory->define(KeyPathway::class, function (Faker $faker) {
    return [
        'key_id'      => fn(): int => factory(Key::class)->create()->id,
        'pathway_id'  => fn(): int => factory(Pathway::class)->create()->id,
        'created_at'  => now(),
        'updated_at'  => now(),
    ];
});
