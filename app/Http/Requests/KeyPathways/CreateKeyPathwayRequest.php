<?php

namespace App\Http\Requests\KeyPathways;

use Illuminate\Foundation\Http\FormRequest;

class CreateKeyPathwayRequest extends FormRequest
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
            'pathway_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
