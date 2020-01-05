<?php

namespace App\Http\Controllers\KeyRooms;

use App\Http\Requests\KeyRooms\CreateKeyRoomRequest;
use App\Http\Resources\KeyRoomResource;
use Domain\KeyRooms\KeyRoom;
use Domain\Keys\Key;
use Domain\Rooms\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateKeyRoomController
{
    public function __invoke(CreateKeyRoomRequest $request, int $key_id): JsonResponse
    {
        $keyRoom = null;
        DB::transaction(
            function () use ($request, $key_id, &$keyRoom) {
                $key = Key::findOrFail($key_id);
                if ($key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $keyExists = Key::query()
                    ->where('project_id', $key->project_id)
                    ->where('id', $request->input('key_id'))
                    ->exists();

                if (! $keyExists) {
                    abort(409, 'Key not found within the same project.');
                }

                $roomExists = Room::query()
                    ->where('project_id', $key->project_id)
                    ->where('id', $request->input('room_id'))
                    ->exists();

                if (! $roomExists) {
                    abort(409, 'Room not found within the same project.');
                }

                $keyRoom = KeyRoom::create([
                    'key_id'  => $request->input('key_id'),
                    'room_id' => $request->input('room_id'),
                ]);
            }
        );

        return (new KeyRoomResource($keyRoom))
            ->toResponse($request);
    }
}
