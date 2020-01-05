<?php

namespace App\Http\Requests\KeyPathways;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKeyPathwayRequest extends FormRequest
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
            'pathway_id' => [
                'integer',
            ],
        ];
    }
}
