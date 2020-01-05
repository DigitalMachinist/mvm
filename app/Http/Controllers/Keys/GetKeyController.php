<?php

namespace App\Http\Controllers\Keys;

use App\Http\Resources\KeyResource;
use Domain\Keys\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetKeyController
{
    public function __invoke(Request $request, int $key_id): JsonResponse
    {
        $key = Key::findOrFail($key_id);

        return (new KeyResource($key))
            ->toResponse($request);
    }
}
