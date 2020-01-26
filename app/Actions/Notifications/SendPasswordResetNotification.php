<?php

namespace App\Actions\Notifications;

use App\Notifications\Auth\PasswordResetNotification;
use Domain\Users\Actions\SetPasswordResetToken;
use Domain\Users\User;

// Refresh the user's password reset token and send a new password reset email.
class SendPasswordResetNotification
{
    private SetPasswordResetToken $setPasswordResetToken;

    public function __construct(SetPasswordResetToken $setPasswordResetToken)
    {
        $this->setPasswordResetToken = $setPasswordResetToken;
    }

    public function execute(User $user, bool $save = true): void
    {
        $this
            ->setPasswordResetToken
            ->execute($user, $save)
            ->notify(new PasswordResetNotification);
    }
}
