<?php

namespace App\Http\Controllers\Keys;

use App\Http\Requests\Keys\CreateKeyRequest;
use App\Http\Resources\KeyResource;
use Domain\Projects\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateKeyController
{
    public function __invoke(CreateKeyRequest $request, int $project_id): JsonResponse
    {
        $key = null;
        DB::transaction(
            function () use ($request, $project_id, &$key) {
                $project = Project::findOrFail($project_id);
                if ($project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $key = $project
                    ->keys()
                    ->create($request->validated());
            }
        );

        return (new KeyResource($key))
            ->toResponse($request);
    }
}
