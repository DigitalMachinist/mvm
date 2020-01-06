<?php

namespace App\Tests\Feature\Controllers\Auth;

use Domain\Users\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Support\Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeReturnsALoginToken(): void
    {
        Event::fake([
            Login::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'             => 'butthead@mtv.net',
                'password'          => Hash::make($password = 'thisrocksdude'),
                'email_verified_at' => now()->subMinute(),
            ]);

        $response = $this
            ->postJson('/api/login', [
                'email'    => $user->email,
                'password' => $password,
            ]);

        $response->assertStatus(200);

        $response->assertSeeText('auth.logged_in');

        $response->assertSeeText('token');

        Event::assertDispatched(
            Login::class
        );
    }

    function testInvokeErrors401WhenCredentialsDontMatch(): void
    {
        Event::fake([
            Login::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'             => 'butthead@mtv.net',
                'password'          => Hash::make($password = 'thisrocksdude'),
                'email_verified_at' => now()->subMinute(),
            ]);

        $response = $this
            ->postJson('/api/login', [
                'email'    => $user->email,
                'password' => $password . 'oops',
            ]);

        $response->assertStatus(401);

        $response->assertSeeText('auth.invalid_credentials');

        $response->assertDontSeeText('token');

        Event::assertNotDispatched(
            Login::class
        );
    }

    function testInvokeErrors403WhenEmailNotVerified(): void
    {
        Event::fake([
            Login::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'             => 'butthead@mtv.net',
                'password'          => Hash::make($password = 'thisrocksdude'),
                'email_verified_at' => null,
            ]);

        $response = $this
            ->postJson('/api/login', [
                'email'    => $user->email,
                'password' => $password,
            ]);

        $response->assertStatus(403);

        $response->assertSeeText('auth.email_not_verified');

        $response->assertDontSeeText('token');

        Event::assertNotDispatched(
            Login::class
        );
    }
}
