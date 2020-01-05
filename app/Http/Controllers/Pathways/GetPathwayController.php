<?php

namespace App\Http\Controllers\Pathways;

use App\Http\Resources\PathwayResource;
use Domain\Pathways\Pathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetPathwayController
{
    public function __invoke(Request $request, int $pathway_id): JsonResponse
    {
        $pathway = Pathway::findOrFail($pathway_id);

        return (new PathwayResource($pathway))
            ->toResponse($request);
    }
}
