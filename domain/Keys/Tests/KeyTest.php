<?php

namespace Domain\Users\Tests;

use Domain\KeyPathways\KeyPathway;
use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class KeyTest extends TestCase
{
    use RefreshDatabase;

    function testKeyPathwaysRelationship(): void
    {
        $project = factory(Project::class)->create();

        $pathways = factory(Pathway::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $key = factory(Key::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyPathways = collect();
        foreach ($pathways as $pathway)
        {
            $keyPathways[] = factory(KeyPathway::class)
                ->create([
                    'key_id'     => $key->id,
                    'pathway_id' => $pathway->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $keyPathways->pluck('pathway_id'),
                $key->key_pathways()->get()->pluck('pathway_id'),
                'Were all of the KeyPathways returned?'
            );
    }

    function testKeyRoomsRelationship(): void
    {
        $project = factory(Project::class)->create();

        $rooms = factory(Room::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $key = factory(Key::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyRooms = collect();
        foreach ($rooms as $room)
        {
            $keyRooms[] = factory(KeyRoom::class)
                ->create([
                    'key_id'  => $key->id,
                    'room_id' => $room->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $keyRooms->pluck('room_id'),
                $key->key_rooms()->get()->pluck('room_id'),
                'Were all of the KeyRooms returned?'
            );
    }

    function testPathwaysRelationship(): void
    {
        $project = factory(Project::class)->create();

        $key = factory(Key::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $pathways = factory(Pathway::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyPathways = collect();
        foreach ($pathways as $pathway)
        {
            $keyPathways[] = factory(KeyPathway::class)
                ->create([
                    'key_id'     => $key->id,
                    'pathway_id' => $pathway->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $pathways->pluck('id'),
                $key->pathways()->get()->pluck('id'),
                'Were all of the Pathways returned?'
            );
    }

    function testProjectRelationship(): void
    {
        $project = factory(Project::class)->create();

        $key = factory(Key::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $this
            ->assertEquals(
                $project->id,
                $key->project()->value('id'),
                'Was the Project returned?'
            );
    }

    function testRoomsRelationship(): void
    {
        $project = factory(Project::class)->create();

        $key = factory(Key::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $rooms = factory(Room::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyRooms = collect();
        foreach ($rooms as $room)
        {
            $keyRooms[] = factory(KeyRoom::class)
                ->create([
                    'key_id'  => $key->id,
                    'room_id' => $room->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $rooms->pluck('id'),
                $key->rooms()->get()->pluck('id'),
                'Were all of the Rooms returned?'
            );
    }
}
