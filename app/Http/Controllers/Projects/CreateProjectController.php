<?php

namespace App\Http\Controllers\Projects;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\JsonResponse;

class CreateProjectController
{
    public function __invoke(CreateProjectRequest $request): JsonResponse
    {
        $project = $request
            ->user()
            ->projects()
            ->create($request->validated());

        return (new ProjectResource($project))
            ->toResponse($request);
    }
}
