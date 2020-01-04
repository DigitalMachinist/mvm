<?php

namespace App\Tests\Feature\Controllers\Pathways;

use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class UpdatePathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeUpdatesAnExistingPathway(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $firelinkShrineEast = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine --> EAST',
            ]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/pathways/{$firelinkShrineEast->id}", [
                'name' => $name = 'ForeLonk Shrone --> WEST',
            ]);

        $response->assertStatus(200);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the Pathway returned?'
            );

        $this
            ->assertDatabaseHas('pathways', [
                'id'   => $firelinkShrineEast->id,
                'name' => $name,
            ]);
    }

    function testInvokeErrors401WhenNotLoggedIn(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $firelinkShrineEast = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine --> EAST',
            ]);

        $this
            ->patchJson("/api/pathways/{$firelinkShrineEast->id}", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

        $firelinkShrineEast = factory(Pathway::class)
            ->create([
                'name'       => 'Firelink Shrine --> EAST',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/pathways/{$firelinkShrineEast->id}", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenPathwayNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->patchJson("/api/pathways/1", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(404);
    }
}
