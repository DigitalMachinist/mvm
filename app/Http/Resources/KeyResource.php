<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'colour'      => '#' . $this->colour,
            'image_url'   => $this->image_url,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
            'project'     => ProjectResource::collection($this->whenLoaded('project')),
            'pathways'    => PathwayResource::collection($this->whenLoaded('pathways')),
            'rooms'       => RoomResource::collection($this->whenLoaded('rooms')),
        ];
    }
}
