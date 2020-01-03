<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'is_public'     => $this->is_public,
            'name'          => $this->name,
            'description'   => $this->description,
            'colour'        => '#' . $this->colour,
            'image_url'     => $this->image_url,
            'created_at'    => $this->created_at->toIso8601String(),
            'updated_at'    => $this->updated_at->toIso8601String(),
            'user'          => new UserResource($this->whenLoaded('user')),
            'start_room'    => new RoomResource($this->whenLoaded('start_room')),
            'keys'          => KeyResource::collection($this->whenLoaded('keys')),
            'rooms'         => RoomResource::collection($this->whenLoaded('rooms')),
            'pathways'      => PathwayResource::collection($this->whenLoaded('pathways')),
        ];
    }
}
