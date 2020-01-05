<?php

namespace App\Http\Controllers\KeyRooms;

use App\Http\Resources\SuccessResource;
use Domain\KeyRooms\KeyRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteKeyRoomController
{
    public function __invoke(Request $request, int $key_id, int $room_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $key_id, $room_id) {
                $keyRoom = KeyRoom::query()
                    ->where('key_id', $key_id)
                    ->where('room_id', $room_id)
                    ->firstOrFail();

                if ($keyRoom->key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $keyRoom->delete();
            }
        );

        return (new SuccessResource)
            ->toResponse($request);
    }
}
