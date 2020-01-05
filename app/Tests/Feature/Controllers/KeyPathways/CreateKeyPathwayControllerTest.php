<?php

namespace App\Tests\Feature\Controllers\KeyPathways;

use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class CreateKeyPathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeCreatesANewKeyPathway(): void
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

        $response = $this
            ->actingAs($user)
            ->postJson("/api/keys/{$masterKey->id}/pathways", [
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);

        $response->assertStatus(201);

        $this
            ->assertEqualsCanonicalizing(
                [
                    'key_id'  => $masterKey->id,
                    'pathway_id' => $firelinkShrine->id,
                ],
                Arr::only($response->decodeResponseJson()['data'], [
                    'key_id',
                    'pathway_id',
                ]),
                'Was the created KeyPathway returned?'
            );

        $this
            ->assertDatabaseHas('key_pathway', [
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ]);
    }

    function testInvokeErrors401WhenNotLoggedIn(): void
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

        $firelinkShrine = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->postJson("/api/keys/{$masterKey->id}/pathways", [
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
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

        $firelinkShrine = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user)
            ->postJson("/api/keys/{$masterKey->id}/pathways", [
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenProjectNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->postJson("/api/keys/1/pathways", [
                'key_id'     => 1,
                'pathway_id' => 1,
            ])
            ->assertStatus(404);
    }

    function testInvokeErrors409WhenKeyDoesntBelongToProject(): void
    {
        $user = factory(User::class)->create();

        $bloodborne = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Bloodborne',
            ]);

        $masterKey = factory(Key::class)
            ->create([
                'project_id' => $bloodborne->id,
                'name'       => 'Master Key',
            ]);

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $firelinkShrine = factory(Pathway::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user)
            ->postJson("/api/keys/{$masterKey->id}/pathways", [
                'key_id'     => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
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
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user)
            ->postJson("/api/keys/{$masterKey->id}/pathways", [
                'key_id'  => $masterKey->id,
                'pathway_id' => $firelinkShrine->id,
            ])
            ->assertStatus(409);
    }
}
