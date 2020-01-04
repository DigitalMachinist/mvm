<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Resources\RoomResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateRoomController
{
    public function __invoke(CreateRoomRequest $request, int $project_id): JsonResponse
    {
        $room = null;
        DB::transaction(
            function () use ($request, $project_id, &$room) {
                $project = Project::findOrFail($project_id);
                if ($project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $room = $project
                    ->rooms()
                    ->create($request->validated());
            }
        );

        return (new RoomResource($room))
            ->toResponse($request);
    }
}
