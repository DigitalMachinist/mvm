<?php

namespace App\Tests\Feature\Controllers\Pathways;

use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetPathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedPathway(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $firelinkShrineEast = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine --> EAST',
            ]);

        $undeadSettlementNorth = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Undead Settlement --> NORTH',
            ]);

        // Add another we don't return to mix it up.
        factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Grand Archives',
            ]);

        $response = $this->getJson("/api/pathways/{$undeadSettlementNorth->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $undeadSettlementNorth->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (Undead Settlement --> NORTH) Pathway returned?'
            );

        $response = $this->getJson("/api/pathways/{$firelinkShrineEast->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $firelinkShrineEast->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (Firelink Shrine --> EAST) Pathway returned?'
            );
    }

    function testInvokeErrors404WhenPathwayNotFound(): void
    {
        $this
            ->getJson("/api/pathways/1")
            ->assertStatus(404);
    }
}
