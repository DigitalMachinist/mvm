<?php

namespace Domain\BadPasswords\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotShortPassword implements Rule
{
    public function passes($attribute, $value)
    {
        return strlen($value) >= config('mvm.auth.password.min_length');
    }

    public function message()
    {
        return 'password.too_short';
    }
}
