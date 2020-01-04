<?php

namespace App\Http\Requests;

class UpdateRoomRequest extends CreateRoomRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'string',
                'max:255',
            ],
            'description' => [
                'string',
            ],
            'difficulty' => [
                'integer',
                'min:1',
            ],
            'x' => [
                'integer',
            ],
            'y' => [
                'integer',
            ],
            'width' => [
                'integer',
            ],
            'height' => [
                'integer',
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
