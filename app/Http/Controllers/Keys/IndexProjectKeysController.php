<?php

namespace App\Http\Controllers\Keys;

use App\Http\Resources\KeyResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexProjectKeysController
{
    public function __invoke(Request $request, int $project_id): JsonResponse
    {
        $project = Project::findOrFail($project_id);

        $keys = $project
            ->keys()
            ->orderBy('name', 'asc')
            ->paginate(config('mvm.pagination.keys.index'));

        return KeyResource::collection($keys)
            ->toResponse($request);
    }
}
