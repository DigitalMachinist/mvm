<?php

namespace App\Tests\Feature;

use Domain\Projects\Project;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class CreateRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeCreatesANewRoom(): void
    {
        $user = factory(User::class)->create();

        $darkSouls = factory(Project::class)
            ->create([
                'user_id' => $user->id,
                'name'    => 'Dark Souls 3',
            ]);

        $response = $this
            ->actingAs($user)
            ->postJson("/api/projects/{$darkSouls->id}/rooms", [
                'name'        => $name = 'Firelink Shrine',
                'description' => 'Time to get LIT',
                'difficulty'  => 1,
                'x'           => 0,
                'y'           => 0,
                'width'       => 1,
                'height'      => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ]);

        $response->assertStatus(201);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the created Room returned?'
            );
    }

    function testInvokeErrors401WhenNotLoggedIn(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $this
            ->postJson("/api/projects/{$darkSouls->id}/rooms", [
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
            ->actingAs($user)
            ->postJson("/api/projects/{$darkSouls->id}/rooms", [
                'name'        => 'Firelink Shrine',
                'description' => 'Time to get LIT',
                'difficulty'  => 1,
                'x'           => 0,
                'y'           => 0,
                'width'       => 1,
                'height'      => 1,
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
            ->postJson("/api/projects/1/rooms", [
                'name'        => 'Firelink Shrine',
                'description' => 'Time to get LIT',
                'difficulty'  => 1,
                'x'           => 0,
                'y'           => 0,
                'width'       => 1,
                'height'      => 1,
                'colour'      => '3344dd',
                'image_url'   => null,
            ])
            ->assertStatus(404);
    }
}
