<?php

namespace Domain\Users\Actions;

use App\Exceptions\Auth\EmailNotVerifiedException;
use App\Exceptions\Auth\InvalidCredentialsException;
use Domain\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;

// Returns a string JWT token the user can provide to be considered logged into the app.
class LoginUser
{
    private AuthManager $auth;

    public function __construct(AuthManager $auth) {
        $this->auth = $auth;
    }

    public function execute(User $user, string $password): string
    {
        $credentials = [
            'email'    => $user->email,
            'password' => $password,
        ];

        event(new Attempting('api', $credentials, false));

        if (! $this->auth->validate($credentials)) {
            event(new Failed('api', $user, $credentials));
            throw new InvalidCredentialsException('Invalid credentials! Probably just a mistype...');
        }

        if (! $user->isEmailVerified()) {
            event(new Failed('api', $user, $credentials));
            throw new EmailNotVerifiedException('You need to verify your email address before you can log in!');
        }

        // Log the user in and return their token.
        $token = $this
            ->auth
            ->login($user);

        event(new Login('api', $user, false));

        return $token;
    }
}
