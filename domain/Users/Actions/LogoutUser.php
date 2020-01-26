<?php

namespace Domain\Users\Actions;

use Domain\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Logout;

// Logs the user out.
class LogoutUser
{
    private AuthManager $auth;

    public function __construct(AuthManager $auth) {
        $this->auth = $auth;
    }

    public function execute(User $user): void
    {
        if (! $this->auth->check($user)) {
            return;
        }

        $this
            ->auth
            ->logout();

        event(new Logout('api', $user));
    }
}
