<?php

namespace App\Tests\Feature\Controllers\Projects;

use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class CreateProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeCreatesANewProject(): void
    {
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user, 'api')
            ->postJson("/api/projects", [
                'name'        => $name = 'Mega Man: Zero',
                'description' => 'Swank-ass trails',
                'is_public'   => true,
                'colour'      => '3344dd',
                'image_url'   => null,
            ]);

        $response->assertStatus(201);

        $this
            ->assertEquals(
                $name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the created Project returned?'
            );

        $this
            ->assertDatabaseHas('projects', [
                'name' => $name,
            ]);
    }

    function testInvokeErrors401WhenNotLoggedIn(): void
    {
        $this
            ->postJson("/api/projects", [
                'name' => 'YOU DIED',
            ])
            ->assertStatus(401);
    }
}
