<?php

namespace App\Tests\Feature\Controllers\Rooms;

use Domain\Projects\Project;
use Domain\Rooms\Room;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class DeleteRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeDeletesAnExistingRoom(): void
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
            ->actingAs($user, 'api')
            ->deleteJson("/api/rooms/{$firelinkShrine->id}");

        $response->assertStatus(200);

        $this
            ->assertDatabaseMissing('rooms', [
                'id' => $firelinkShrine->id,
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
            ->deleteJson("/api/rooms/{$firelinkShrine->id}")
            ->assertStatus(401);
    }

    function testInvokeErrors403WhenProjectNotOwnedByRequestor(): void
    {
        $user = factory(User::class)->create();

        $firelinkShrine = factory(Room::class)
            ->create([
                'name' => 'Firelink Shrine',
            ]);

        $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/rooms/{$firelinkShrine->id}")
            ->assertStatus(403);
    }

    function testInvokeErrors404WhenRoomNotFound(): void
    {
        $user = factory(User::class)->create();

        $this
            ->actingAs($user, 'api')
            ->deleteJson("/api/rooms/1")
            ->assertStatus(404);
    }
}
