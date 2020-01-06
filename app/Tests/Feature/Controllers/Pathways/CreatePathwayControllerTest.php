<?php

namespace App\Tests\Feature\Controllers\Pathways;

use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class CreatePathwayControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeCreatesANewPathway(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $response = $this
            ->actingAs($user, 'api')
            ->postJson("/api/projects/{$darkSouls->id}/pathways", [
                'name'        => $name = 'Firelink Shrine --> EAST',
                'description' => 'Time to get BIT',
                'difficulty'  => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ]);

        $response->assertStatus(201);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the created Pathway returned?'
            );

        $this
            ->assertDatabaseHas('pathways', [
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
            ->postJson("/api/projects/{$darkSouls->id}/pathways", [
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
            ->actingAs($user, 'api')
            ->postJson("/api/projects/{$darkSouls->id}/pathways", [
                'name'        => 'Firelink Shrine --> EAST',
                'description' => 'Time to get BIT',
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
            ->actingAs($user, 'api')
            ->postJson("/api/projects/1/pathways", [
                'name'        => 'Firelink Shrine --> EAST',
                'description' => 'Time to get BIT',
                'difficulty'  => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ])
            ->assertStatus(404);
    }
}
