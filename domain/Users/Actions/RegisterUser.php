<?php

namespace Domain\Users\Actions;

use App\Actions\Notifications\SendEmailVerifyNotification;
use Domain\Users\Actions\SetPassword;
use Domain\Users\User;
use Illuminate\Auth\Events\Registered;

class RegisterUser
{
    private SetPassword $setPassword;
    private SendEmailVerifyNotification $sendEmail;

    public function __construct(SetPassword $setPassword, SendEmailVerifyNotification $sendEmail)
    {
        $this->setPassword = $setPassword;
        $this->sendEmail = $sendEmail;
    }

    public function execute(string $email, string $password, string $name): User
    {
        $user = new User;
        $user->email = $email;
        $user->name = $name;

        // Hash the requested password and assign it but don't save the user yet.
        // Note: This can throw a BadPasswordException.
        $this
            ->setPassword
            ->execute($user, $password, false);

        // Send a verification email and save the user.
        $this
            ->sendEmail
            ->execute($user, true);

        // Signal that the user is now registered.
        event(new Registered($user));

        return $user;
    }
}
