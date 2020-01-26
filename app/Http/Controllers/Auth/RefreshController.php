<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\BaseResource;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshController
{
    public function __invoke(
        Request $request,
        AuthManager $auth
    ): JsonResponse
    {
        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status' => 'auth.refreshed',
                    'token'  => $auth->refresh(),
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(200);
    }
}
