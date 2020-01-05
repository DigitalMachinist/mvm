<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'is_public' => [
                'boolean',
            ],
            'name' => [
                'string',
                'max:255',
            ],
            'description' => [
                'string',
            ],
            'colour' => [
                'nullable',
                'string',
                'regex:/[0-9a-z]{6}/i',
            ],
            'image_url' => [
                'nullable',
                'url',
            ],
        ];
    }
}
