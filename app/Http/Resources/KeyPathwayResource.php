<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeyPathwayResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'key_id'     => $this->key_id,
            'pathway_id' => $this->pathway_id,
            'key'        => new KeyResource($this->whenLoaded('key')),
            'pathway'    => new PathwayResource($this->whenLoaded('pathway')),
        ];
    }
}
