<?php

namespace App\Http\Controllers\Pathways;

use App\Http\Requests\CreatePathwayRequest;
use App\Http\Resources\PathwayResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreatePathwayController
{
    public function __invoke(CreatePathwayRequest $request, int $project_id): JsonResponse
    {
        $pathway = null;
        DB::transaction(
            function () use ($request, $project_id, &$pathway) {
                $project = Project::findOrFail($project_id);
                if ($project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $pathway = $project
                    ->pathways()
                    ->create($request->validated());
            }
        );

        return (new PathwayResource($pathway))
            ->toResponse($request);
    }
}
