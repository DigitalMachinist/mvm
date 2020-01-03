<?php

namespace App\Http\Controllers\Projects;

use App\Http\Resources\ProjectResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetProjectController
{
    public function __invoke(Request $request, int $project_id): JsonResponse
    {
        $project = Project::findOrFail($project_id);

        return (new ProjectResource($project))
            ->toResponse($request);
    }
}
