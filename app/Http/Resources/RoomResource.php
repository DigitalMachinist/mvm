<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'difficulty'  => $this->difficulty,
            'x'           => $this->x,
            'y'           => $this->y,
            'width'       => $this->width,
            'height'      => $this->height,
            'colour'      => '#' . $this->colour,
            'image_url'   => $this->image_url,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
            'project'     => ProjectResource::collection($this->whenLoaded('project')),
            'keys'        => KeyResource::collection($this->whenLoaded('keys')),
            'pathways'    => PathwayResource::collection($this->whenLoaded('pathways')),
        ];
    }
}
