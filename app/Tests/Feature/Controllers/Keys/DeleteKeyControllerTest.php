<?php

namespace App\Tests\Feature\Controllers\Keys;

use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class DeleteKeyControllerTest extends TestCase
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

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/keys/{$masterKey->id}");

        $response->assertStatus(200);

        $this
            ->assertDatabaseMissing('keys', [
                'id' => $masterKey->id,
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

        $this
            ->deleteJson("/api/keys/{$masterKey->id}")
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

        $masterKey = factory(Key::class)
            ->create([
                'name' => 'Master Key',
            ]);

        $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/keys/{$masterKey->id}")
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/keys/1")
            ->assertStatus(404);
    }
}
