<?php

namespace Domain\Users\Tests;

use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    function testKeysRelationship(): void
    {
        $project = factory(Project::class)->create();

        $keys = factory(Key::class, 3)
            ->create([
                'project_id' => $project->id,
            ]);

        $this
            ->assertEqualsCanonicalizing(
                $keys->pluck('id'),
                $project->keys()->get()->pluck('id'),
                'Were all of the Keys returned?'
            );
    }

    function testPathwaysRelationship(): void
    {
        $project = factory(Project::class)->create();

        $pathways = factory(Pathway::class, 3)
            ->create([
                'project_id' => $project->id,
            ]);

        $this
            ->assertEqualsCanonicalizing(
                $pathways->pluck('id'),
                $project->pathways()->get()->pluck('id'),
                'Were all of the Pathways returned?'
            );
    }

    function testRoomsRelationship(): void
    {
        $project = factory(Project::class)->create();

        $rooms = factory(Room::class, 3)
            ->create([
                'project_id' => $project->id,
            ]);

        $this
            ->assertEqualsCanonicalizing(
                $rooms->pluck('id'),
                $project->rooms()->get()->pluck('id'),
                'Were all of the Rooms returned?'
            );
    }

    function testStartRoomRelationship(): void
    {
        $user = factory(User::class)->create();

        $startRoom = factory(Room::class)->create();

        $project = factory(Project::class)
            ->create([
                'user_id'       => $user->id,
                'start_room_id' => $startRoom->id,
            ]);

        $this
            ->assertEquals(
                $startRoom->id,
                $project->start_room()->value('id'),
                'Was the Start Room returned?'
            );
    }

    function testUserRelationship(): void
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->assertEquals(
                $user->id,
                $project->user()->value('id'),
                'Was the User returned?'
            );
    }
}
