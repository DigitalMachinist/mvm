<?php

namespace App\Tests\Feature\Controllers\Auth;

use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Tests\TestCase;

class RefreshControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeRefreshesTheUsersToken(): void
    {
        $user = factory(User::class)->create();

        auth()->login($user);

        $token = auth()->tokenById($user->id);

        $response = $this
            ->actingAs($user, 'api')
            ->postJson('/api/refresh');

        $response->assertStatus(200);

        $response->assertSeeText('auth.refreshed');

        $this
            ->assertNotEquals(
                $token,
                data_get($response->decodeResponseJson(), 'meta.token')
            );
    }
}
