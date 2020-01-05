<?php

namespace App\Http\Controllers\KeyPathways;

use App\Http\Requests\KeyPathways\UpdateKeyPathwayRequest;
use App\Http\Resources\KeyPathwayResource;
use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateKeyPathwayController
{
    public function __invoke(UpdateKeyPathwayRequest $request, int $key_id, int $pathway_id): JsonResponse
    {
        $keyPathway = null;
        DB::transaction(
            function () use ($request, $key_id, $pathway_id, &$keyPathway) {
                $keyPathway = KeyPathway::query()
                    ->where('key_id', $key_id)
                    ->where('pathway_id', $pathway_id)
                    ->firstOrFail();

                if ($keyPathway->key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                if ($request->exists('key_id')) {
                    $keyExists = Key::query()
                        ->where('project_id', $keyPathway->key->project_id)
                        ->where('id', $request->input('key_id'))
                        ->exists();

                    if (! $keyExists) {
                        abort(409, 'Key not found within the requested project.');
                    }
                }

                if ($request->has('pathway_id')) {
                    $pathwayExists = Pathway::query()
                        ->where('project_id', $keyPathway->key->project_id)
                        ->where('id', $request->input('pathway_id'))
                        ->exists();

                    if (! $pathwayExists) {
                        abort(409, 'Pathway not found within the requested project.');
                    }
                }

                $keyPathway
                    ->fill($request->validated())
                    ->save();
            }
        );

        return (new KeyPathwayResource($keyPathway))
            ->toResponse($request);
    }
}
