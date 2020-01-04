<?php

namespace App\Http\Controllers\Projects;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateProjectController
{
    public function __invoke(CreateProjectRequest $request, int $project_id): JsonResponse
    {
        $project = null;
        DB::transaction(
            function () use ($request, $project_id, &$project) {
                $project = Project::findOrFail($project_id);
                if ($project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $project
                    ->fill($request->validated())
                    ->save();
            }
        );

        return (new ProjectResource($project))
            ->toResponse($request);
    }
}
