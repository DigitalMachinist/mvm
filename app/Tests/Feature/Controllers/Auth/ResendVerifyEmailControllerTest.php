<?php

namespace App\Tests\Feature\Controllers\Auth;

use App\Notifications\Auth\EmailVerifyNotification;
use Domain\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Support\Tests\TestCase;

class ResendVerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeSendsANewVerificationEmail(): void
    {
        Notification::fake([
            EmailVerifyNotification::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'              => 'beavis@mtv.net',
                'email_verified_at'  => null,
                'email_verify_token' => $oldToken = Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify/resend', [
                'email' => $user->email,
            ]);

        $response->assertStatus(200);

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->where('email_verify_token', $oldToken)
                    ->exists(),
                'The user\'s email verify token has not changed.'
            );

        Notification::assertSentTo(
            $user, EmailVerifyNotification::class
        );
    }

    function testInvokeReturns200ButDoesNothingWhenEmailNotFound(): void
    {
        Notification::fake([
            EmailVerifyNotification::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'              => 'beavis@mtv.net',
                'email_verified_at'  => null,
                'email_verify_token' => $oldToken = Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify/resend', [
                'email' => 'butthead@mtv.net',
            ]);

        $response->assertStatus(200);

        $this
            ->assertTrue(
                User::query()
                    ->where('email', $user->email)
                    ->where('email_verify_token', $oldToken)
                    ->exists(),
                'The user\'s email verify token has changed.'
            );

        Notification::assertNotSentTo(
            $user, EmailVerifyNotification::class
        );
    }

    function testInvokeReturns200ButDoesNothingWhenEmailIsVerified(): void
    {
        Notification::fake([
            EmailVerifyNotification::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'              => 'beavis@mtv.net',
                'email_verified_at'  => now(),
                'email_verify_token' => $oldToken = Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify/resend', [
                'email' => $user->email,
            ]);

        $response->assertStatus(200);

        $this
            ->assertTrue(
                User::query()
                    ->where('email', $user->email)
                    ->where('email_verify_token', $oldToken)
                    ->exists(),
                'The user\'s email verify token has changed.'
            );

        Notification::assertNotSentTo(
            $user, EmailVerifyNotification::class
        );
    }
}
