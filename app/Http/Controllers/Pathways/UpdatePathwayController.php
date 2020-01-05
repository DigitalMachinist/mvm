<?php

namespace App\Http\Controllers\Pathways;

use App\Http\Requests\Pathways\UpdatePathwayRequest;
use App\Http\Resources\PathwayResource;
use Domain\Pathways\Pathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdatePathwayController
{
    public function __invoke(UpdatePathwayRequest $request, int $pathway_id): JsonResponse
    {
        $pathway = null;
        DB::transaction(
            function () use ($request, $pathway_id, &$pathway) {
                $pathway = Pathway::findOrFail($pathway_id);
                if ($pathway->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $pathway
                    ->fill($request->validated())
                    ->save();
            }
        );

        return (new PathwayResource($pathway))
            ->toResponse($request);
    }
}
