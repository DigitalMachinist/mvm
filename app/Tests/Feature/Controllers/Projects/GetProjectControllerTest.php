<?php

namespace App\Tests\Feature;

use Domain\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedProject(): void
    {
        $castlevania = factory(Project::class)
            ->create([
                'name' => 'Castlevania: Symphony of the Night',
            ]);

        $metroid = factory(Project::class)
            ->create([
                'name' => 'Super Metroid',
            ]);

        // Add another we don't return to mix it up.
        factory(Project::class)
            ->create([
                'name' => 'Super Mario World',
            ]);

        $response = $this->getJson("/api/projects/{$castlevania->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $castlevania->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (castlevania) Project returned?'
            );

        $response = $this->getJson("/api/projects/{$metroid->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $metroid->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (metroid) Project returned?'
            );
    }

    function testInvokeErrors404WhenProjectNotFound(): void
    {
        $this
            ->getJson("/api/projects/1")
            ->assertStatus(404);
    }
}
