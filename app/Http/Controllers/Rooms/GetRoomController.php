<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Resources\RoomResource;
use Domain\Rooms\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetRoomController
{
    public function __invoke(Request $request, int $room_id): JsonResponse
    {
        $room = Room::findOrFail($room_id);

        return (new RoomResource($room))
            ->toResponse($request);
    }
}
