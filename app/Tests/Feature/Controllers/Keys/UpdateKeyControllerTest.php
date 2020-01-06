<?php

namespace App\Tests\Feature\Controllers\Keys;

use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class UpdateKeyControllerTest extends TestCase
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

        $response = $this
            ->actingAs($user, 'api')
            ->patchJson("/api/keys/{$masterKey->id}", [
                'name' => $name = 'Master Sword',
            ]);

        $response->assertStatus(200);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the Key returned?'
            );

        $this
            ->assertDatabaseHas('keys', [
                'id'   => $masterKey->id,
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

        $masterKey = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Master Key',
            ]);

        $this
            ->patchJson("/api/keys/{$masterKey->id}", [
                'name' => 'YOU DIED',
            ])
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
            ->patchJson("/api/keys/{$masterKey->id}", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'api')
            ->patchJson("/api/keys/1", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(404);
    }
}
