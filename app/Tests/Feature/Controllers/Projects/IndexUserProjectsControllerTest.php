<?php

namespace App\Tests\Feature;

use Arr;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Support\Tests\TestCase;

class InderUserProjectsControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedUsersProjects(): void
    {
        $user = factory(User::class)->create();

        $projects = collect([
            'Castlevania: Symphony of the Night',
            'Super Metroid',
            'Super Mario World',
        ])
        ->map(function ($name) use ($user) {
            return factory(Project::class)
                ->create([
                    'user_id' => $user->id,
                    'name'    => $name,
                ]);
        });

        // Add a project that doesn't belong to the user.
        factory(Project::class)
            ->create([
                'user_id' => factory(User::class)->create()->id,
                'name'    => 'Bloodborne',
            ]);

        $response = $this->getJson("/api/users/{$user->id}/projects");

        // Are the returned projects owned by $user?
        $this
            ->assertEqualsCanonicalizing(
                $projects
                    ->where('user_id', $user->id)
                    ->pluck('name')
                    ->toArray(),
                Arr::pluck($response->decodeResponseJson()['data'], 'name'),
                'Were only the requested user\'s projects returned?'
            );
    }

    function testInvokeErrors404WhenUserNotFound(): void
    {
        // Get the next index after the latest user record.
        $id = (DB::table('users')->max('id') + 1) ?? 1;

        $this
            ->getJson("/api/users/{$id}/projects")
            ->assertStatus(404);
    }
}
