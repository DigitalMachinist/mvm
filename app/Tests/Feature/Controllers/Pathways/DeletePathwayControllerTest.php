<?php

namespace App\Tests\Feature\Controllers\Pathways;

use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class DeletePathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeDeletesAnExistingPathway(): void
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
            ->deleteJson("/api/pathways/{$firelinkShrineEast->id}");

        $response->assertStatus(200);

        $this
            ->assertDatabaseMissing('pathways', [
                'id' => $firelinkShrineEast->id,
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
            ->deleteJson("/api/pathways/{$firelinkShrineEast->id}")
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

        $firelinkShrineEast = factory(Pathway::class)
            ->create([
                'name' => 'Firelink Shrine --> EAST',
            ]);

        $this
            ->actingAs($user)
            ->deleteJson("/api/pathways/{$firelinkShrineEast->id}")
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenPathwayNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->deleteJson("/api/pathways/1")
            ->assertStatus(404);
    }
}
