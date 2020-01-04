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

        $this
            ->assertEqualsCanonicalizing(
                $projects
                    ->where('user_id', $user->id)
                    ->pluck('name')
                    ->toArray(),
                Arr::pluck($response->decodeResponseJson()['data'], 'name'),
                'Were only the requested User\'s Projects returned?'
            );
    }

    function testInvokeErrors404WhenUserNotFound(): void
    {
        $this
            ->getJson("/api/users/1/projects")
            ->assertStatus(404);
    }
}
