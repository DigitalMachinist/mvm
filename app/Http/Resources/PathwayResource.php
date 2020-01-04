<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PathwayResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'difficulty'  => $this->difficulty,
            'colour'      => '#' . $this->colour,
            'image_url'   => $this->image_url,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
            'project'     => new ProjectResource($this->whenLoaded('project')),
            'room_1'      => new RoomResource($this->whenLoaded('room_1')),
            'room_2'      => new RoomResource($this->whenLoaded('room_2')),
            'keys'        => KeyResource::collection($this->whenLoaded('keys')),
        ];
    }
}
