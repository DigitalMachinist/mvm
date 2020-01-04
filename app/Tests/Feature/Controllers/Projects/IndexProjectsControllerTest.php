<?php

namespace App\Tests\Feature;

use Arr;
use Domain\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class IndexProjectsControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsAllProjects(): void
    {
        $projects = collect([
            'Castlevania: Symphony of the Night',
            'Super Metroid',
            'Super Mario World',
        ])
        ->map(function ($name) {
            return factory(Project::class)
                ->create([
                    'name' => $name,
                ]);
        });

        $response = $this->getJson("/api/projects");

        $response->assertOk();
        $response->assertSee('meta');

        $this
            ->assertEqualsCanonicalizing(
                $projects
                    ->pluck('name')
                    ->toArray(),
                Arr::pluck($response->decodeResponseJson()['data'], 'name'),
                'Were all of the projects (for all users) returned?'
            );
    }
}
