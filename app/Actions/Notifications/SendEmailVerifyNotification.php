<?php

namespace App\Actions\Notifications;

use App\Notifications\Auth\EmailVerifyNotification;
use Domain\Users\Actions\SetEmailVerifyToken;
use Domain\Users\User;

// Refresh the user's email verify token and send a new verification email.
class SendEmailVerifyNotification
{
    private SetEmailVerifyToken $setEmailVerifyToken;

    public function __construct(SetEmailVerifyToken $setEmailVerifyToken)
    {
        $this->setEmailVerifyToken = $setEmailVerifyToken;
    }

    public function execute(User $user, bool $save = true): void
    {
        $this
            ->setEmailVerifyToken
            ->execute($user, $save)
            ->notify(new EmailVerifyNotification);
    }
}
