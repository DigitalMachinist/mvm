<?php

namespace App\Http\Controllers\Keys;

use App\Http\Requests\Keys\UpdateKeyRequest;
use App\Http\Resources\KeyResource;
use Domain\Keys\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateKeyController
{
    public function __invoke(UpdateKeyRequest $request, int $key_id): JsonResponse
    {
        $key = null;
        DB::transaction(
            function () use ($request, $key_id, &$key) {
                $key = Key::findOrFail($key_id);
                if ($key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $key
                    ->fill($request->validated())
                    ->save();
            }
        );

        return (new KeyResource($key))
            ->toResponse($request);
    }
}
