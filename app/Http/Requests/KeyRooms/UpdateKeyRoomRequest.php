<?php

namespace App\Http\Requests\KeyRooms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKeyRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key_id' => [
                'integer',
            ],
            'room_id' => [
                'integer',
            ],
        ];
    }
}
