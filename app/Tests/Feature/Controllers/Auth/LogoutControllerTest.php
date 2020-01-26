<?php

namespace App\Tests\Feature\Controllers\Auth;

use Domain\Users\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Support\Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeInvalidatesTheUsersToken(): void
    {
        Event::fake([
            Logout::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'             => 'butthead@mtv.net',
                'password'          => Hash::make($password = 'thisrocksdude'),
                'email_verified_at' => now()->subMinute(),
            ]);

        auth()->login($user);

        $response = $this
            ->actingAs($user, 'api')
            ->postJson('/api/logout');

        $response->assertStatus(200);

        $response->assertSeeText('auth.logged_out');

        Event::assertDispatched(
            Logout::class
        );
    }
}
