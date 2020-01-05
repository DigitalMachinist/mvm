<?php

namespace App\Tests\Feature\Controllers\KeyPathways;

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetKeyPathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedKey(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $masterKey = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Master Key',
            ]);

        $firelinkShrine = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyPathway to be updated.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $response = $this->getJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}");

        $response->assertOk();

        $this
            ->assertEqualsCanonicalizing(
                [
                    'key_id'     => $keyPathway->key_id,
                    'pathway_id' => $keyPathway->pathway_id,
                ],
                Arr::only($response->decodeResponseJson()['data'], [
                    'key_id',
                    'pathway_id',
                ]),
                'Was the requested KeyPathway returned?'
            );
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $this
            ->getJson("/api/keys/1/pathways/1")
            ->assertStatus(404);
    }
}
