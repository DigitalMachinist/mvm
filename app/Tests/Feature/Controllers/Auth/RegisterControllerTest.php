<?php

namespace App\Tests\Feature\Controllers\Auth;

use App\Notifications\Auth\EmailVerifyNotification;
use Domain\BadPasswords\BadPassword;
use Domain\Users\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Support\Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeRegistersANewUser(): void
    {
        Event::fake([
            Registered::class,
        ]);

        Notification::fake([
            EmailVerifyNotification::class,
        ]);

        $response = $this
            ->postJson('/api/register', [
                'email'    => $email = 'butthead@mtv.net',
                'password' => 'thisrocksdude',
                'name'     => 'Butthead',
            ]);

        $response->assertStatus(201);

        $response->assertSeeText('auth.registered');

        $this
            ->assertDatabaseHas('users', [
                'email' => $email,
            ]);

        Event::assertDispatched(
            Registered::class
        );

        Notification::assertSentTo(
            User::first(), EmailVerifyNotification::class
        );
    }

    function testInvokeErrors422WhenPasswordIsInsecure(): void
    {
        Event::fake([
            \Illuminate\Auth\Events\Registered::class,
        ]);

        BadPassword::create([
            'password' => $password = 'thegreatcornholio',
        ]);

        $response = $this
            ->postJson('/api/register', [
                'email'    => $email = 'beavis@mtv.net',
                'password' => $password,
                'name'     => 'Beavis',
            ]);

        $response->assertStatus(422);

        $response->assertSeeText('validation.failed');

        $response
            ->assertJsonFragment([
                'errors' => [
                    'password' => [
                        'password.insecure',
                    ],
                ],
            ]);

        $this
            ->assertDatabaseMissing('users', [
                'email' => $email,
            ]);

        Event::assertNotDispatched(
            Registered::class
        );
    }
}
