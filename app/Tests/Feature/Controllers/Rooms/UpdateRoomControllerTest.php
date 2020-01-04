<?php

namespace App\Tests\Feature;

use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class UpdateRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeUpdatesAnExistingRoom(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/rooms/{$firelinkShrine->id}", [
                'name' => $name = 'ForeLonk Shrone',
            ]);

        $response->assertStatus(200);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the Room returned?'
            );

        $this
            ->assertDatabaseHas('rooms', [
                'id'   => $firelinkShrine->id,
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

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->patchJson("/api/rooms/{$firelinkShrine->id}", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

        $firelinkShrine = factory(Room::class)
            ->create([
                'name'       => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user)
            ->patchJson("/api/rooms/{$firelinkShrine->id}", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenRoomNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->patchJson("/api/rooms/1", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(404);
    }
}
