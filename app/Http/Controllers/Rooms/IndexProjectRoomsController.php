<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Resources\RoomResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexProjectRoomsController
{
    public function __invoke(Request $request, int $project_id): JsonResponse
    {
        $project = Project::findOrFail($project_id);

        $rooms = $project
            ->rooms()
            ->orderBy('name', 'asc')
            ->paginate(config('mvm.pagination.rooms.index'));

        return RoomResource::collection($rooms)
            ->toResponse($request);
    }
}
