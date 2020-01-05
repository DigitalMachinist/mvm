<?php

namespace App\Tests\Feature\Controllers\KeyRooms;

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetKeyRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedKey(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $masterKey = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Master Key',
            ]);

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyRoom to be updated.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $response = $this->getJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}");

        $response->assertOk();

        $this
            ->assertEqualsCanonicalizing(
                [
                    'key_id'  => $keyRoom->key_id,
                    'room_id' => $keyRoom->room_id,
                ],
                Arr::only($response->decodeResponseJson()['data'], [
                    'key_id',
                    'room_id',
                ]),
                'Was the requested (Blighttown Key) Key returned?'
            );
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $this
            ->getJson("/api/keys/1/rooms/1")
            ->assertStatus(404);
    }
}
