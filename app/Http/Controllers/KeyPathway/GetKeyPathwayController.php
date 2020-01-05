<?php

namespace App\Http\Controllers\KeyPathways;

use App\Http\Resources\KeyPathwayResource;
use Domain\KeyPathways\KeyPathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetKeyPathwayController
{
    public function __invoke(Request $request, int $key_id, int $pathway_id): JsonResponse
    {
        $keyPathway = KeyPathway::query()
            ->where('key_id', $key_id)
            ->where('pathway_id', $pathway_id)
            ->firstOrFail();

        return (new KeyPathwayResource($keyPathway))
            ->toResponse($request);
    }
}
