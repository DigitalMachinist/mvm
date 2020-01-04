<?php

namespace App\Tests\Feature\Controllers\Rooms;

use Arr;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Support\Tests\TestCase;

class InderProjectRoomsControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedProjectsRooms(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $rooms = collect([
            'Firelink Shrine',
            'Undead Settlement',
            'Great Archive',
        ])
        ->map(function ($name) use ($darkSouls) {
            return factory(Room::class)
                ->create([
                    'project_id' => $darkSouls->id,
                    'name'       => $name,
                ]);
        });

        // Add a project that doesn't belong to Dark Souls 3.
        factory(Room::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'    => 'The Nexus',
            ]);

        $response = $this->getJson("/api/projects/{$darkSouls->id}/rooms");

        $this
            ->assertEqualsCanonicalizing(
                $rooms
                    ->where('project_id', $darkSouls->id)
                    ->pluck('name')
                    ->toArray(),
                Arr::pluck($response->decodeResponseJson()['data'], 'name'),
                'Were only the requested Project\'s Rooms returned?'
            );
    }

    function testInvokeErrors404WhenUserNotFound(): void
    {
        $this
            ->getJson("/api/users/1/projects")
            ->assertStatus(404);
    }
}
