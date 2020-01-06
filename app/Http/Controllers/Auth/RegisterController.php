<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\BaseResource;
use Domain\Users\Actions\RegisterUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegisterController
{
    public function __invoke(
        RegisterRequest $request,
        RegisterUser $registerUser
    ): JsonResponse
    {
        DB::transaction(function () use ($request, $registerUser) {
            try {
                $registerUser
                    ->execute(
                        $request->input('email'),
                        $request->input('password'),
                        $request->input('name')
                    );
            }
            catch (\Domain\Users\Exceptions\BadPasswordException $e) {
                throw ValidationException::withMessages([
                    'password' => 'password.insecure',
                ]);
            }
        });

        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status' => 'auth.registered',
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(201);
    }
}
