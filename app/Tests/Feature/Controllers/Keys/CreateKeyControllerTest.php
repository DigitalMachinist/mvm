<?php

namespace App\Tests\Feature\Controllers\Keys;

use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class CreateKeyControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeCreatesANewKey(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $response = $this
            ->actingAs($user)
            ->postJson("/api/projects/{$darkSouls->id}/keys", [
                'name'        => $name = 'Master Key',
                'description' => 'Open Sesame',
                'difficulty'  => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ]);

        $response->assertStatus(201);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the created Key returned?'
            );

        $this
            ->assertDatabaseHas('keys', [
                'name' => $name,
            ]);
    }

    function testInvokeErrors401WhenNotLoggedIn(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $this
            ->postJson("/api/projects/{$darkSouls->id}/keys", [
                'name' => 'YOU DIED',
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

        $this
            ->actingAs($user)
            ->postJson("/api/projects/{$darkSouls->id}/keys", [
                'name'        => 'Master Key',
                'description' => 'Open Sesame',
                'difficulty'  => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenProjectNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->postJson("/api/projects/1/keys", [
                'name'        => 'Master Key',
                'description' => 'Open Sesame',
                'difficulty'  => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ])
            ->assertStatus(404);
    }
}
