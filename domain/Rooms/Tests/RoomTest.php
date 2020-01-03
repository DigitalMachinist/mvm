<?php

namespace Domain\Users\Tests;

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    function testKeyRoomsRelationship(): void
    {
        $project = factory(Project::class)->create();

        $keys = factory(Key::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $room = factory(Room::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyRooms = collect();
        foreach ($keys as $key)
        {
            $keyRooms[] = factory(KeyRoom::class)
                ->create([
                    'key_id'  => $key->id,
                    'room_id' => $room->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $keyRooms->pluck('key_id'),
                $room->key_rooms()->get()->pluck('key_id')
            );
    }

    function testProjectRelationship(): void
    {
        $project = factory(Project::class)->create();

        $room = factory(Room::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $this->assertEquals($project->id, $room->project()->value('id'));
    }
}
