<?php

namespace App\Http\Requests\Rooms;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
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
            'x' => [
                'required',
                'integer',
            ],
            'y' => [
                'required',
                'integer',
            ],
            'width' => [
                'required',
                'integer',
            ],
            'height' => [
                'required',
                'integer',
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
