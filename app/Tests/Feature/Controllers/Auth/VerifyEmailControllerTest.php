<?php

namespace App\Tests\Feature\Controllers\Auth;

use Domain\Users\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Support\Tests\TestCase;

class VerifyEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeVerifiesTheUsersEmail(): void
    {
        Event::fake([
            Verified::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                   => 'beavis@mtv.net',
                'email_verified_at'       => null,
                'email_verify_expires_at' => now()->addMinute(),
                'email_verify_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify', [
                'token' => $user->email_verify_token,
            ]);

        $response->assertStatus(200);

        $response->assertSeeText('auth.verified');

        $this
            ->assertTrue(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('email_verified_at')
                    ->exists(),
                'The user\'s email is not verified.'
            );

        Event::assertDispatched(
            Verified::class
        );
    }

    function testInvokeErrors401WhenTokenIsExpired(): void
    {
        Event::fake([
            Verified::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                   => 'beavis@mtv.net',
                'email_verified_at'       => null,
                'email_verify_expires_at' => now()->subMinute(),
                'email_verify_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify', [
                'token' => $user->email_verify_token,
            ]);

        $response->assertStatus(401);

        // $response->assertSeeText('auth.email_verify_token_expired');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('email_verified_at')
                    ->exists(),
                'The user\'s email is verified.'
            );

        Event::assertNotDispatched(
            Verified::class
        );
    }

    function testInvokeErrors404WhenTokenNotFound(): void
    {
        Event::fake([
            Verified::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                   => 'beavis@mtv.net',
                'email_verified_at'       => null,
                'email_verify_expires_at' => now()->addMinute(),
                'email_verify_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify', [
                'token' => $user->email_verify_token . 'oops',
            ]);

        $response->assertStatus(404);

        // $response->assertSeeText('error');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('email_verified_at')
                    ->exists(),
                'The user\'s email is verified.'
            );

        Event::assertNotDispatched(
            Verified::class
        );
    }

    function testInvokeErrors409WhenUserIsAlreadyVerified(): void
    {
        Event::fake([
            Verified::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                   => 'beavis@mtv.net',
                'email_verified_at'       => now(),
                'email_verify_expires_at' => now()->addMinute(),
                'email_verify_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/verify', [
                'token' => $user->email_verify_token,
            ]);

        $response->assertStatus(409);

        // $response->assertSeeText('auth.email_already_verified');

        Event::assertNotDispatched(
            Verified::class
        );
    }
}
