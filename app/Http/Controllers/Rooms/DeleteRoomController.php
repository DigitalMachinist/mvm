<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Resources\SuccessResource;
use Domain\Rooms\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteRoomController
{
    public function __invoke(Request $request, int $room_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $room_id, &$room) {
                $room = Room::findOrFail($room_id);
                if ($room->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $room->delete();
            }
        );

        return (new SuccessResource)
            ->toResponse($request);
    }
}
