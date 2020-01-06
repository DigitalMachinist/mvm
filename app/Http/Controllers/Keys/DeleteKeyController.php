<?php

namespace App\Http\Controllers\Keys;

use App\Http\Resources\BaseResource;
use Domain\Keys\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteKeyController
{
    public function __invoke(Request $request, int $key_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $key_id) {
                $key = Key::findOrFail($key_id);
                if ($key->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $key->delete();
            }
        );

        return (new BaseResource)
            ->toResponse($request);
    }
}
