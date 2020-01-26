<?php

namespace App\Tests\Feature\Controllers\KeyPathways;

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class DeleteKeyPathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeDeletesAnExistingKey(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
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

        // The KeyPathway to be deleted.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}");

        $response->assertStatus(200);

        $this
            ->assertDatabaseMissing('key_pathway', [
                'key_id'     => $keyPathway->key_id,
                'pathway_id' => $keyPathway->pathway_id,
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

        // The KeyPathway to be deleted.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $this
            ->deleteJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}")
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

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

        // The KeyPathway to be deleted.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}")
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/keys/1/pathways/1")
            ->assertStatus(404);
    }
}
