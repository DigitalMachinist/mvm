<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\BaseResource;
use Domain\Users\Actions\LogoutUser;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController
{
    public function __invoke(
        Request $request,
        LogoutUser $logoutUser,
        AuthManager $auth
    ): JsonResponse
    {
        $logoutUser->execute($auth->user());

        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status' => 'auth.logged_out',
                    'token'  => null,
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(200);
    }
}
