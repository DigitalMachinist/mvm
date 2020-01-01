<?php

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Rooms\Room;
use Faker\Generator as Faker;

$factory->define(KeyRoom::class, function (Faker $faker) {
    return [
        'key_id'      => fn(): int => factory(Key::class)->create()->id,
        'room_id'     => fn(): int => factory(Room::class)->create()->id,
        'created_at'  => now(),
        'updated_at'  => now(),
    ];
});
