<?php

namespace Domain\Users\Actions;

use Domain\BadPasswords\Rules\NotBadPassword;
use Domain\BadPasswords\Rules\NotShortPassword;
use Domain\Users\Exceptions\BadPasswordException;
use Domain\Users\Exceptions\SetPasswordExpiredException;
use Domain\Users\Exceptions\ShortPasswordException;
use Domain\Users\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Hashing\HashManager;

// Set the user's password with a newly hashed password.
class SetPassword
{
    private HashManager $hash;
    private NotBadPassword $notBad;
    private NotShortPassword $notShort;

    public function __construct(HashManager $hash, NotBadPassword $notBad, NotShortPassword $notShort)
    {
        $this->hash = $hash;
        $this->notBad = $notBad;
        $this->notShort = $notShort;
    }

    public function execute(User $user, string $password, bool $save = true): User
    {
        if ($user->isPasswordResetExpired()) {
            throw new SetPasswordExpiredException('Your password reset window has ended. Begin a new password reset.');
        }

        if (! $this->notShort->passes('password', $password)) {
            throw new ShortPasswordException('Your password is too short. Try something longer.');
        }

        if (! $this->notBad->passes('password', $password)) {
            throw new BadPasswordException('Your password is insecure. Try something more unique.');
        }

        $user->password = $this->hash->make($password);
        $user->password_reset_expires_at = null;
        $user->password_reset_token = null;

        if ($save) {
            $user->save();
        }

        event(new PasswordReset($user));

        return $user;
    }
}
