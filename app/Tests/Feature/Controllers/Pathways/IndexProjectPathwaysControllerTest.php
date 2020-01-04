<?php

namespace App\Tests\Feature\Controllers\Pathways;

use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class InderProjectPathwaysControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedProjectsPathways(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $pathways = collect([
            'Firelink Shrine --> EAST',
            'Undead Settlement --> NORTH',
            'Great Archive --> WEST',
        ])
        ->map(function ($name) use ($darkSouls) {
            return factory(Pathway::class)
                ->create([
                    'project_id' => $darkSouls->id,
                    'name'       => $name,
                ]);
        });

        // Add a project that doesn't belong to Dark Souls 3.
        factory(Pathway::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'The Nexus --> SOUTH',
            ]);

        $response = $this->getJson("/api/projects/{$darkSouls->id}/pathways");

        $this
            ->assertEqualsCanonicalizing(
                $pathways
                    ->where('project_id', $darkSouls->id)
                    ->pluck('name')
                    ->toArray(),
                Arr::pluck($response->decodeResponseJson()['data'], 'name'),
                'Were only the requested Project\'s Pathways returned?'
            );
    }

    function testInvokeErrors404WhenUserNotFound(): void
    {
        $this
            ->getJson("/api/projects/1/pathways")
            ->assertStatus(404);
    }
}
