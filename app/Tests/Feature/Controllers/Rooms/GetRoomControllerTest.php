<?php

namespace App\Tests\Feature;

use Domain\Projects\Project;
use Domain\Rooms\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedRoom(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $firelinkShrine = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Firelink Shrine',
            ]);

        $undeadSettlement = factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Undead Settlement',
            ]);

        // Add another we don't return to mix it up.
        factory(Room::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Grand Archives',
            ]);

        $response = $this->getJson("/api/rooms/{$undeadSettlement->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $undeadSettlement->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (Undead Settlement) Room returned?'
            );

        $response = $this->getJson("/api/rooms/{$firelinkShrine->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $firelinkShrine->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (Firelink Shrine) Room returned?'
            );
    }

    function testInvokeErrors404WhenRoomNotFound(): void
    {
        $this
            ->getJson("/api/rooms/1")
            ->assertStatus(404);
    }
}
