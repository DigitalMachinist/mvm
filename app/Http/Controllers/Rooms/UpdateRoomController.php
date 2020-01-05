<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Requests\Rooms\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use Domain\Rooms\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateRoomController
{
    public function __invoke(UpdateRoomRequest $request, int $room_id): JsonResponse
    {
        $room = null;
        DB::transaction(
            function () use ($request, $room_id, &$room) {
                $room = Room::findOrFail($room_id);
                if ($room->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $room
                    ->fill($request->validated())
                    ->save();
            }
        );

        return (new RoomResource($room))
            ->toResponse($request);
    }
}
