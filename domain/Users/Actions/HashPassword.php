<?php

namespace Domain\Users\Actions;

use Domain\BadPasswords\BadPassword;
use Domain\Users\Exceptions\BadPasswordException;
use Illuminate\Hashing\HashManager;

// Hash a password and return it or throw an exception if the password is insecure.
class HashPassword
{
    private HashManager $hash;

    public function __construct(HashManager $hash)
    {
        $this->hash = $hash;
    }

    public function execute(string $password): string
    {
        $isBadPassword = BadPassword::query()
            ->where('password', $password)
            ->exists();

        if ($isBadPassword) {
            throw new BadPasswordException('Your password sucks, dude. Try something more unique.');
        }

        return $this
            ->hash
            ->make($password);
    }
}
