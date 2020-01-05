<?php

namespace App\Http\Requests\Keys;

use Illuminate\Foundation\Http\FormRequest;

class CreateKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'present',
                'string',
            ],
            'difficulty' => [
                'required',
                'integer',
                'min:1',
            ],
            'colour' => [
                'required',
                'nullable',
                'string',
                'regex:/[0-9a-z]{6}/i',
            ],
            'image_url' => [
                'present',
                'nullable',
                'url',
            ],
        ];
    }
}
