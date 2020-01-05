<?php

namespace App\Http\Controllers\KeyRooms;

use App\Http\Requests\KeyRooms\UpdateKeyRoomRequest;
use App\Http\Resources\KeyRoomResource;
use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Rooms\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateKeyRoomController
{
    public function __invoke(UpdateKeyRoomRequest $request, int $key_id, int $room_id): JsonResponse
    {
        $keyRoom = null;
        DB::transaction(
            function () use ($request, $key_id, $room_id, &$keyRoom) {
                $keyRoom = KeyRoom::query()
                    ->where('key_id', $key_id)
                    ->where('room_id', $room_id)
                    ->firstOrFail();

                if ($keyRoom->key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                if ($request->exists('key_id')) {
                    $keyExists = Key::query()
                        ->where('project_id', $keyRoom->key->project_id)
                        ->where('id', $request->input('key_id'))
                        ->exists();

                    if (! $keyExists) {
                        abort(409, 'Key not found within the requested project.');
                    }
                }

                if ($request->has('room_id')) {
                    $roomExists = Room::query()
                        ->where('project_id', $keyRoom->key->project_id)
                        ->where('id', $request->input('room_id'))
                        ->exists();

                    if (! $roomExists) {
                        abort(409, 'Room not found within the requested project.');
                    }
                }

                $keyRoom
                    ->fill($request->validated())
                    ->save();
            }
        );

        return (new KeyRoomResource($keyRoom))
            ->toResponse($request);
    }
}
