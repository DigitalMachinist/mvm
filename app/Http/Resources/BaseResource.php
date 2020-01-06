<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    public function __construct($resource = [])
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return compact($this->resource);
    }

    public function with($request)
    {
        return [
            'meta' => [
                'status' => [],
            ],
        ];
    }
}
