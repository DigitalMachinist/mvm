<?php

namespace App\Tests\Feature\Controllers\KeyRooms;

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class DeleteKeyRoomControllerTest extends TestCase
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

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyRoom to be deleted.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $response = $this
            ->actingAs($user)
            ->deleteJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}");

        $response->assertStatus(200);

        $this
            ->assertDatabaseMissing('key_room', [
                'key_id'  => $keyRoom->key_id,
                'room_id' => $keyRoom->room_id,
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

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyRoom to be deleted.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $this
            ->deleteJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}")
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

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyRoom to be deleted.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $this
            ->actingAs($user)
            ->deleteJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}")
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->deleteJson("/api/keys/1/rooms/1")
            ->assertStatus(404);
    }
}
