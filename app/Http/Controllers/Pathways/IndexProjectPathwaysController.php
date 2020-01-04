<?php

namespace App\Http\Controllers\Pathways;

use App\Http\Resources\PathwayResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexProjectPathwaysController
{
    public function __invoke(Request $request, int $project_id): JsonResponse
    {
        $project = Project::findOrFail($project_id);

        $pathways = $project
            ->pathways()
            ->orderBy('name', 'asc')
            ->paginate(config('mvm.pagination.pathways.index'));

        return PathwayResource::collection($pathways)
            ->toResponse($request);
    }
}
