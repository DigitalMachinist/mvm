<?php

namespace App\Tests\Feature\Controllers\KeyPathways;

use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class UpdateKeyPathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeUpdatesAnExistingKey(): void
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

        // The KeyPathway to be updated.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $undeadSettlement = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}", [
                'pathway_id' => $undeadSettlement->id,
            ]);

        $response->assertStatus(200);

        $this
            ->assertEqualsCanonicalizing(
                [
                    'key_id'     => $masterKey->id,
                    'pathway_id' => $undeadSettlement->id,
                ],
                Arr::only($response->decodeResponseJson()['data'], [
                    'key_id',
                    'pathway_id',
                ]),
                'Was the KeyPathway returned?'
            );

        $this
            ->assertDatabaseHas('key_pathway', [
                'key_id'     => $masterKey->id,
                'pathway_id' => $undeadSettlement->id,
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

        // The KeyPathway to be updated.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $undeadSettlement = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->patchJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}", [
                'pathway_id' => $undeadSettlement->id,
            ])
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

        // The KeyPathway to be updated.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $undeadSettlement = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}", [
                'pathway_id' => $undeadSettlement->id,
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/1/pathways/1", [
                'pathway_id' => 1,
            ])
            ->assertStatus(404);
    }

    function testInvokeErrors409WhenKeyDoesntBelongToProject(): void
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

        // The KeyPathway to be updated.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $skeletonKey = factory(Key::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'Skeleton Key',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}", [
                'key_id'  => $skeletonKey->id,
            ])
            ->assertStatus(409);
    }

    function testInvokeErrors409WhenPathwayDoesntBelongToProject(): void
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

        // The KeyPathway to be updated.
        $keyPathway = factory(KeyPathway::class)
            ->create([
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $theNexus = factory(Pathway::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'The Nexus',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyPathway->key_id}/pathways/{$keyPathway->pathway_id}", [
                'pathway_id' => $theNexus->id,
            ])
            ->assertStatus(409);
    }
}
