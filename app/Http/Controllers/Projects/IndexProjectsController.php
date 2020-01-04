<?php

namespace App\Http\Controllers\Projects;

use App\Http\Resources\ProjectResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexProjectsController
{
    public function __invoke(Request $request): JsonResponse
    {
        $projects = Project::query()
            ->orderBy('updated_at', 'desc')
            ->paginate(config('mvm.pagination.projects.index'));

        return ProjectResource::collection($projects)
            ->toResponse($request);
    }
}
