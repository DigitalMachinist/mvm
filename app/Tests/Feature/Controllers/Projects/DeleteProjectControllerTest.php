<?php

namespace App\Tests\Feature;

use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class DeleteProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeEditsAnExistingProject(): void
    {
        $user = factory(User::class)->create();

        $project = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Metroid 2',
            ]);

        $response = $this
            ->actingAs($user)
            ->deleteJson("/api/projects/{$project->id}");

        $response->assertStatus(200);

        $this
            ->assertDatabaseMissing('projects', [
                'id' => $project->id,
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
            ->deleteJson("/api/projects/{$project->id}")
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
            ->deleteJson("/api/projects/{$project->id}")
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenProjectNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->deleteJson("/api/projects/1")
            ->assertStatus(404);
    }
}
