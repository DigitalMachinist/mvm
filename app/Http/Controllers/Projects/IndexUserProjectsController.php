<?php

namespace App\Http\Controllers\Projects;

use App\Http\Resources\ProjectResource;
use Domain\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexUserProjectsController
{
    public function __invoke(Request $request, int $user_id): JsonResponse
    {
        $user = User::findOrFail($user_id);

        $projects = $user
            ->projects()
            ->orderBy('updated_at', 'desc')
            ->paginate(config('mvm.pagination.projects.index'));

        return ProjectResource::collection($projects)
            ->toResponse($request);
    }
}
