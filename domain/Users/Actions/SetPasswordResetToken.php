<?php

namespace Domain\Users\Actions;

use Domain\Users\User;
use Illuminate\Support\Str;

class SetPasswordResetToken
{
    public function execute(User $user, bool $save = true): User
    {
        $user->password_reset_expires_at = now()->addHours(config('mvm.auth.password_reset.expire_hours'));
        $user->password_reset_token = Str::random(config('mvm.auth.password_reset.token_length'));

        if ($save) {
            $user->save();
        }

        return $user;
    }
}
