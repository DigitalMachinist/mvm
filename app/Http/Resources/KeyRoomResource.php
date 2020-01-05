<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeyRoomResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'key_id'  => $this->key_id,
            'room_id' => $this->room_id,
            'key'     => new KeyResource($this->whenLoaded('key')),
            'room'    => new RoomResource($this->whenLoaded('room')),
        ];
    }
}
