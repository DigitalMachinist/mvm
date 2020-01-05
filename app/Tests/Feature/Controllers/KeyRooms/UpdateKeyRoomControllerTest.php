<?php

namespace App\Tests\Feature\Controllers\KeyRooms;

use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class UpdateKeyRoomControllerTest extends TestCase
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

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyRoom to be updated.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $undeadSettlement = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}", [
                'room_id' => $undeadSettlement->id,
            ]);

        $response->assertStatus(200);

        $this
            ->assertEqualsCanonicalizing(
                [
                    'key_id'  => $masterKey->id,
                    'room_id' => $undeadSettlement->id,
                ],
                Arr::only($response->decodeResponseJson()['data'], [
                    'key_id',
                    'room_id',
                ]),
                'Was the KeyRoom returned?'
            );

        $this
            ->assertDatabaseHas('key_room', [
                'key_id'  => $masterKey->id,
                'room_id' => $undeadSettlement->id,
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

        // The KeyRoom to be updated.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $undeadSettlement = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->patchJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}", [
                'room_id' => $undeadSettlement->id,
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

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        // The KeyRoom to be updated.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $undeadSettlement = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}", [
                'room_id' => $undeadSettlement->id,
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/1/rooms/1", [
                'room_id' => 1,
            ])
            ->assertStatus(404);
    }

    function testInvokeErrors409WhenKeyDoesntBelongToProject()
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

        // The KeyRoom to be updated.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $skeletonKey = factory(Key::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'Skeleton Key',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}", [
                'key_id'  => $skeletonKey->id,
            ])
            ->assertStatus(409);
    }

    function testInvokeErrors409WhenRoomDoesntBelongToProject()
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

        // The KeyRoom to be updated.
        $keyRoom = factory(KeyRoom::class)
            ->create([
                'key_id'  => $masterKey->id,
                'room_id' => $firelinkShrine->id,
            ]);

        $theNexus = factory(Room::class)
            ->create([
                'project_id' => factory(Project::class)->create()->id,
                'name'       => 'The Nexus',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/keys/{$keyRoom->key_id}/rooms/{$keyRoom->room_id}", [
                'room_id' => $theNexus->id,
            ])
            ->assertStatus(409);
    }
}
