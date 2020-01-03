<?php

namespace Domain\Users\Tests;

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class PathwayTest extends TestCase
{
    use RefreshDatabase;

    function testKeyPathwaysRelationship(): void
    {
        $project = factory(Project::class)->create();

        $keys = factory(Key::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $pathway = factory(Pathway::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyPathways = collect();
        foreach ($keys as $key)
        {
            $keyPathways[] = factory(KeyPathway::class)
                ->create([
                    'key_id'     => $key->id,
                    'pathway_id' => $pathway->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $keyPathways->pluck('key_id'),
                $pathway->key_pathways()->get()->pluck('key_id'),
                'Were all of the KeyPathways returned?'
            );
    }

    function testKeysRelationship(): void
    {
        $project = factory(Project::class)->create();

        $keys = factory(Key::class, 2)
            ->create([
                'project_id' => $project->id,
            ]);

        $pathway = factory(Pathway::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $keyPathways = collect();
        foreach ($keys as $key)
        {
            $keyPathways[] = factory(KeyPathway::class)
                ->create([
                    'key_id'     => $key->id,
                    'pathway_id' => $pathway->id,
                ]);
        }

        $this
            ->assertEqualsCanonicalizing(
                $keyPathways->pluck('key_id'),
                $pathway->keys()->get()->pluck('id'),
                'Were all of the Keys returned?'
            );
    }

    function testProjectRelationship(): void
    {
        $project = factory(Project::class)->create();

        $pathway = factory(Pathway::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $this
            ->assertEquals(
                $project->id,
                $pathway->project()->value('id'),
                'Was the Project returned?'
            );
    }

    function testKeyRoom1Relationship(): void
    {
        $project = factory(Project::class)->create();

        $room = factory(Room::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $pathway = factory(Pathway::class)
            ->create([
                'project_id' => $project->id,
                'room_1_id'  => $room->id,
            ]);

        $this
            ->assertEquals(
                $room->id,
                $pathway->room_1()->value('id'),
                'Was Room 1 returned?'
            );
    }

    function testKeyRoom2Relationship(): void
    {
        $project = factory(Project::class)->create();

        $room = factory(Room::class)
            ->create([
                'project_id' => $project->id,
            ]);

        $pathway = factory(Pathway::class)
            ->create([
                'project_id' => $project->id,
                'room_2_id'  => $room->id,
            ]);

        $this
            ->assertEquals(
                $room->id,
                $pathway->room_2()->value('id'),
                'Was Room 2 returned?'
            );
    }
}
