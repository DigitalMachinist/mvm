<?php

namespace App\Tests\Feature\Controllers\Keys;

use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class InderProjectKeysControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedProjectsKeys(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $keys = collect([
            'Master Key',
            'Blighttown Key',
            'Basement Key',
        ])
        ->map(function ($name) use ($darkSouls) {
            return factory(Key::class)
                ->create([
                    'project_id' => $darkSouls->id,
                    'name'       => $name,
                ]);
        });

        // Add a project that doesn't belong to Dark Souls 3.
        factory(Key::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'Keyblade',
            ]);

        $response = $this->getJson("/api/projects/{$darkSouls->id}/keys");

        $this
            ->assertEqualsCanonicalizing(
                $keys
                    ->where('project_id', $darkSouls->id)
                    ->pluck('name')
                    ->toArray(),
                Arr::pluck($response->decodeResponseJson()['data'], 'name'),
                'Were only the requested Project\'s Keys returned?'
            );
    }

    function testInvokeErrors404WhenUserNotFound(): void
    {
        $this
            ->getJson("/api/projects/1/keys")
            ->assertStatus(404);
    }
}
