<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_public' => [
                'required',
                'boolean',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'present',
                'string',
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
