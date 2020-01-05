<?php

namespace App\Http\Requests\KeyRooms;

use Illuminate\Foundation\Http\FormRequest;

class CreateKeyRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key_id' => [
                'required',
                'integer',
            ],
            'room_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
