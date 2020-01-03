<?php

namespace Domain\Users\Tests;

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Rooms\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class KeyRoomTest extends TestCase
{
    use RefreshDatabase;

    function testKeyRelationship(): void
    {
        $key = factory(Key::class)->create();

        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id' => $key->id,
            ]);

        $this->assertEquals($key->id, $keyRoom->key()->value('id'));
    }

    function testRoomRelationship(): void
    {
        $room = factory(Room::class)->create();

        $keyRoom = factory(KeyRoom::class)
            ->create([
                'room_id' => $room->id,
            ]);

        $this->assertEquals($room->id, $keyRoom->room()->value('id'));
    }
}
