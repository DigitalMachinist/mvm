<?php

namespace Domain\BadPasswords\Rules;

use Domain\BadPasswords\BadPassword;
use Illuminate\Contracts\Validation\Rule;

class NotBadPassword implements Rule
{
    public function passes($attribute, $value)
    {
        return ! BadPassword::where('password', $value)->exists();
    }

    public function message()
    {
        return 'password.insecure';
    }
}
