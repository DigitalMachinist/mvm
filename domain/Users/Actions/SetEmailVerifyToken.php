<?php

namespace Domain\Users\Actions;

use Domain\Users\User;
use Illuminate\Support\Str;

class SetEmailVerifyToken
{
    public function execute(User $user, bool $save = true): User
    {
        $user->email_verify_token = Str::random(config('mvm.auth.verify_email.token_length'));
        $user->email_verify_expires_at = now()->addHours(config('mvm.auth.verify_email.expire_hours'));

        if ($save) {
            $user->save();
        }

        return $user;
    }
}
