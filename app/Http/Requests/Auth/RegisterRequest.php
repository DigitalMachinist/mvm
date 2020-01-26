<?php

namespace App\Http\Requests\Auth;

use Domain\BadPasswords\Rules\NotBadPassword;
use Domain\BadPasswords\Rules\NotShortPassword;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                app(NotShortPassword::class),
                app(NotBadPassword::class),
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
        ];
    }
}
