<?php

namespace App\Http\Controllers\KeyPathways;

use App\Http\Requests\KeyPathways\CreateKeyPathwayRequest;
use App\Http\Resources\KeyPathwayResource;
use Domain\KeyPathways\KeyPathway;
use Domain\Keys\Key;
use Domain\Pathways\Pathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateKeyPathwayController
{
    public function __invoke(CreateKeyPathwayRequest $request, int $key_id): JsonResponse
    {
        $keyPathway = null;
        DB::transaction(
            function () use ($request, $key_id, &$keyPathway) {
                $key = Key::findOrFail($key_id);
                if ($key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $keyExists = Key::query()
                    ->where('project_id', $key->project_id)
                    ->where('id', $request->input('key_id'))
                    ->exists();

                if (! $keyExists) {
                    abort(409, 'Key not found within the same project.');
                }

                $pathwayExists = Pathway::query()
                    ->where('project_id', $key->project_id)
                    ->where('id', $request->input('pathway_id'))
                    ->exists();

                if (! $pathwayExists) {
                    abort(409, 'Pathway not found within the same project.');
                }

                $keyPathway = KeyPathway::create([
                    'key_id'     => $request->input('key_id'),
                    'pathway_id' => $request->input('pathway_id'),
                ]);
            }
        );

        return (new KeyPathwayResource($keyPathway))
            ->toResponse($request);
    }
}
