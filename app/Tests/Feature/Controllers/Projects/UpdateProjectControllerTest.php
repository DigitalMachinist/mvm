<?php

namespace App\Tests\Feature;

use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class UpdateProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeUpdatesAnExistingProject(): void
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Metroid 2',
            ]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/projects/{$project->id}", [
                'name'        => $name = 'Super Metroid',
                'description' => 'Swank-ass trails',
                'is_public'   => true,
                'colour'      => '3344dd',
                'image_url'   => null,
            ]);

        $response->assertStatus(200);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the Project returned?'
            );

        $this
            ->assertDatabaseHas('projects', [
                'id'   => $project->id,
                'name' => $name,
            ]);
    }

    function testInvokeErrors401WhenNotLoggedIn(): void
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Metroid 2',
            ]);

        $this
            ->patchJson("/api/projects/{$project->id}", [
                'name'        => 'YOU DIED',
                'description' => 'Swank-ass trails',
                'is_public'   => true,
                'colour'      => '3344dd',
                'image_url'   => null,
            ])
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)
            ->create([
                'user_id' => factory(User::class)->create()->id,
                'name'    => 'Metroid 2',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/projects/{$project->id}", [
                'name'        => 'YOU DIED',
                'description' => 'Swank-ass trails',
                'is_public'   => true,
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
            ->patchJson("/api/projects/1", [
                'name'        => 'YOU DIED',
                'description' => 'Swank-ass trails',
                'is_public'   => true,
                'colour'      => '3344dd',
                'image_url'   => null,
            ])
            ->assertStatus(404);
    }
}
