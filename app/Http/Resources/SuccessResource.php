<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    public function __construct(string $message = '')
    {
        // $this->resource gets set to $message.
        parent::__construct($message);
    }

    public function toArray($request)
    {
        return [
            'success' => true,
            'message' => $this->resource,
        ];
    }
}
