<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\SetPasswordRequest;
use App\Http\Resources\BaseResource;
use Domain\Users\Actions\SetPassword;
use Domain\Users\Exceptions\SetPasswordExpiredException;
use Domain\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SetPasswordController
{
    public function __invoke(
        SetPasswordRequest $request,
        SetPassword $setPassword
    ): JsonResponse
    {
        DB::transaction(function () use ($request, $setPassword) {
            // If the token lookup fails, return 404.
            $user = User::query()
                ->where('password_reset_token', $request->input('token'))
                ->firstOrFail();

            try {
                // Clear the user's forgot password token and expiry, update their password, and save the user.
                // Note: This can throw both ShortPasswordException & BadPasswordException  as well,
                // but they will both be caught in validation by SetPasswordRequest so they won't happen here.
                $setPassword->execute($user, $request->input('password'), true);
            }
            catch (SetPasswordExpiredException $e) {
                // If the user's token has expired, return 401.
                throw new UnauthorizedHttpException('', 'auth.password_reset_expired', $e);
            }
        });

        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status' => 'auth.password_reset',
                ],
            ])
            ->toResponse($request);
    }
}
