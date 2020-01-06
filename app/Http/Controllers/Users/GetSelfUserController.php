<?php

namespace App\Http\Controllers\Users;

use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetSelfUserController
{
    public function __invoke(
        Request $request,
        AuthManager $auth
    ): JsonResponse
    {
        return (new UserResource($auth->user()))
            ->toResponse($request)
            ->setStatusCode(200);
    }
}
