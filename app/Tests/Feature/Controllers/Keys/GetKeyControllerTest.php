<?php

namespace App\Tests\Feature\Controllers\Keys;

use Domain\Keys\Key;
use Domain\Projects\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Support\Tests\TestCase;

class GetKeyControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsTheRequestedKey(): void
    {
        $darkSouls = factory(Project::class)
            ->create([
                'name' => 'Dark Souls 3',
            ]);

        $masterKey = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Master Key',
            ]);

        $blighttownKey = factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Blighttown Key',
            ]);

        // Add another we don't return to mix it up.
        factory(Key::class)
            ->create([
                'project_id' => $darkSouls->id,
                'name'       => 'Basement Key',
            ]);

        $response = $this->getJson("/api/keys/{$blighttownKey->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $blighttownKey->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (Blighttown Key) Key returned?'
            );

        $response = $this->getJson("/api/keys/{$masterKey->id}");
        $response->assertOk();
        $this
            ->assertEquals(
                $masterKey->name,
                Arr::get($response->decodeResponseJson(), 'data.name'),
                'Was the requested (Master Key) Key returned?'
            );
    }

    function testInvokeErrors404WhenKeyNotFound(): void
    {
        $this
            ->getJson("/api/keys/1")
            ->assertStatus(404);
    }
}
