<?php

namespace App\Http\Requests\Auth;

use Domain\BadPasswords\Rules\NotBadPassword;
use Domain\BadPasswords\Rules\NotShortPassword;
use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
                app(NotShortPassword::class),
                app(NotBadPassword::class),
            ],
        ];
    }
}
