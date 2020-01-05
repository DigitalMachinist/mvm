<?php

namespace App\Http\Controllers\KeyPathways;

use App\Http\Resources\SuccessResource;
use Domain\KeyPathways\KeyPathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteKeyPathwayController
{
    public function __invoke(Request $request, int $key_id, int $pathway_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $key_id, $pathway_id) {
                $keyPathway = KeyPathway::query()
                    ->where('key_id', $key_id)
                    ->where('pathway_id', $pathway_id)
                    ->firstOrFail();

                if ($keyPathway->key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $keyPathway->delete();
            }
        );

        return (new SuccessResource)
            ->toResponse($request);
    }
}
