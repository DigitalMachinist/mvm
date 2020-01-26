<?php

namespace App\Http\Controllers\Projects;

use App\Http\Resources\BaseResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteProjectController
{
    public function __invoke(Request $request, int $project_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $project_id) {
                $project = Project::findOrFail($project_id);
                if ($project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $project->delete();
            }
        );

        return (new BaseResource)
            ->toResponse($request);
    }
}
