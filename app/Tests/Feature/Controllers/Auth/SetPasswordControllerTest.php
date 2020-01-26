<?php

namespace App\Tests\Feature\Controllers\Auth;

use Domain\BadPasswords\BadPassword;
use Domain\Users\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Support\Tests\TestCase;

class SetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    function testInvokeSetsTheUsersPassword(): void
    {
        Event::fake([
            PasswordReset::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                     => 'beavis@mtv.net',
                'password_reset_at'         => null,
                'password_reset_expires_at' => now()->addMinute(),
                'password_reset_token'      => $oldToken = Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password', [
                'token'    => $user->password_reset_token,
                'password' => Str::random(config('mvm.auth.password.min_length')),
            ]);

        $response->assertStatus(200);

        $response->assertSeeText('auth.password_reset');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->where('password_reset_token', $oldToken)
                    ->exists(),
                'The user\'s password reset token has not changed.'
            );

        Event::assertDispatched(
            PasswordReset::class
        );
    }

    function testInvokeErrors401WhenTokenIsExpired(): void
    {
        Event::fake([
            PasswordReset::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                     => 'beavis@mtv.net',
                'password_reset_at'         => null,
                'password_reset_expires_at' => now()->subMinute(),
                'password_reset_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password', [
                'token'    => $user->password_reset_token,
                'password' => Str::random(config('mvm.auth.password.min_length')),
            ]);

        $response->assertStatus(401);

        // $response->assertSeeText('auth.password_reset_token_expired');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('password_reset_at')
                    ->exists(),
                'The user\'s password was set.'
            );

        Event::assertNotDispatched(
            PasswordReset::class
        );
    }

    function testInvokeErrors404WhenTokenNotFound(): void
    {
        Event::fake([
            PasswordReset::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                   => 'beavis@mtv.net',
                'email_verified_at'       => null,
                'email_verify_expires_at' => now()->addMinute(),
                'email_verify_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password', [
                'token'    => $user->password_reset_token . 'oops',
                'password' => Str::random(config('mvm.auth.password.min_length')),
            ]);

        $response->assertStatus(404);

        // $response->assertSeeText('error');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('password_reset_at')
                    ->exists(),
                'The user\'s password was set.'
            );

        Event::assertNotDispatched(
            PasswordReset::class
        );
    }

    function testInvokeErrors422WhenPasswordIsTooShort(): void
    {
        Event::fake([
            PasswordReset::class,
        ]);

        $user = factory(User::class)
            ->create([
                'email'                     => 'beavis@mtv.net',
                'password_reset_at'         => null,
                'password_reset_expires_at' => now()->addMinute(),
                'password_reset_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password', [
                'token'    => $user->password_reset_token,
                'password' => Str::random(config('mvm.auth.password.min_length') - 1),
            ]);

        $response->assertStatus(422);

        $response->assertSeeText('password.too_short');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('password_reset_at')
                    ->exists(),
                'The user\'s password was set.'
            );

        Event::assertNotDispatched(
            PasswordReset::class
        );
    }

    function testInvokeErrors422WhenPasswordIsInsecure(): void
    {
        Event::fake([
            PasswordReset::class,
        ]);

        BadPassword::create([
            'password' => $password = Str::random(config('mvm.auth.password.min_length')),
        ]);

        $user = factory(User::class)
            ->create([
                'email'                     => 'beavis@mtv.net',
                'password_reset_at'         => null,
                'password_reset_expires_at' => now()->addMinute(),
                'password_reset_token'      => Str::random(100),
            ]);

        $response = $this
            ->postJson('/api/password', [
                'token'    => $user->password_reset_token,
                'password' => $password,
            ]);

        $response->assertStatus(422);

        $response->assertSeeText('password.insecure');

        $this
            ->assertFalse(
                User::query()
                    ->where('email', $user->email)
                    ->whereNotNull('password_reset_at')
                    ->exists(),
                'The user\'s password was set.'
            );

        Event::assertNotDispatched(
            PasswordReset::class
        );
    }
}
