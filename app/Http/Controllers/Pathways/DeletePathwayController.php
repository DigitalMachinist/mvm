<?php

namespace App\Http\Controllers\Pathways;

use App\Http\Resources\BaseResource;
use Domain\Pathways\Pathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeletePathwayController
{
    public function __invoke(Request $request, int $pathway_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $pathway_id) {
                $pathway = Pathway::findOrFail($pathway_id);
                if ($pathway->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $pathway->delete();
            }
        );

        return (new BaseResource)
            ->toResponse($request);
    }
}
