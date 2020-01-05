<?php

namespace App\Http\Controllers\KeyRooms;

use App\Http\Resources\KeyRoomResource;
use Domain\KeyRooms\KeyRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetKeyRoomController
{
    public function __invoke(Request $request, int $key_id, int $room_id): JsonResponse
    {
        $keyRoom = KeyRoom::query()
            ->where('key_id', $key_id)
            ->where('room_id', $room_id)
            ->firstOrFail();

        return (new KeyRoomResource($keyRoom))
            ->toResponse($request);
    }
}
