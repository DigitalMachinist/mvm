<?php

namespace App\Http\Controllers\Pathways;

use App\Http\Resources\SuccessResource;
use Domain\Pathways\Pathway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeletePathwayController
{
    public function __invoke(Request $request, int $room_id): JsonResponse
    {
        DB::transaction(
            function () use ($request, $room_id) {
                $pathway = Pathway::findOrFail($room_id);
                if ($pathway->project->user_id !== $request->user()->id) {
                    abort(403, 'Not yours.');
                }

                $pathway->delete();
            }
        );

        return (new SuccessResource)
            ->toResponse($request);
    }
}
