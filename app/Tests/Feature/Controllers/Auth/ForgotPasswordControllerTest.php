<?php

namespace App\Tests\Feature\Controllers\Auth;

use App\Notifications\Auth\PasswordResetNotification;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Support\Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeSendsANewForgotPasswordEmail(): void
    {
        Notification::fake([
            PasswordResetNotification::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                => 'beavis@mtv.net',
                'password_reset_token' => $oldToken = Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password/forgot', [
                'email' => $user->email,
            ]);

        $response->assertStatus(200);

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->where('password_reset_token', $oldToken)
                    ->exists(),
                'The user\'s password reset token has not changed.'
            );

        Notification::assertSentTo(
            $user, PasswordResetNotification::class
        );
    }

    function testInvokeReturns200ButDoesNothingWhenEmailNotFound(): void
    {
        Notification::fake([
            PasswordResetNotification::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                => 'beavis@mtv.net',
                'password_reset_token' => $oldToken = Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password/forgot', [
                'email' => 'butthead@mtv.net',
            ]);

        $response->assertStatus(200);

        $this
            ->assertTrue(
                User::query()
                    ->where('email', $user->email)
                    ->where('password_reset_token', $oldToken)
                    ->exists(),
                'The user\'s password reset token has changed.'
            );

        Notification::assertNotSentTo(
            $user, PasswordResetNotification::class
        );
    }
}
