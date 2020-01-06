<?php

namespace Domain\Users\Actions;

use Domain\Users\Exceptions\EmailAlreadyVerifiedException;
use Domain\Users\Exceptions\VerifyEmailExpiredException;
use Domain\Users\User;
use Illuminate\Auth\Events\Verified;

class VerifyEmail
{
    public function execute(User $user, bool $save = true): User
    {
        if ($user->isEmailVerifyExpired()) {
            throw new VerifyEmailExpiredException('Your email verify window has ended. Request a fresh verification email.');
        }

        if ($user->isEmailVerified()) {
            throw new EmailAlreadyVerifiedException('Your email address is already verified.');
        }

        $user->email_verify_token = null;
        $user->email_verify_expires_at = null;
        $user->email_verified_at = now();

        if ($save) {
            $user->save();
        }

        event(new Verified($user));

        return $user;
    }
}
