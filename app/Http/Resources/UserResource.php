<?php

namespace App\Http\Resources;

class UserResource extends BaseResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'projects' => ProjectResource::collection($this->whenLoaded('project')),
        ];
    }
}
