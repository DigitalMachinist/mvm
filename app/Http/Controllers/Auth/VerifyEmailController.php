<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Resources\BaseResource;
use Domain\Users\Actions\VerifyEmail;
use Domain\Users\Exceptions\EmailAlreadyVerifiedException;
use Domain\Users\Exceptions\VerifyEmailExpiredException;
use Domain\Users\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class VerifyEmailController
{
    public function __invoke(
        VerifyEmailRequest $request,
        VerifyEmail $verifyEmail
    ): JsonResponse
    {
        DB::transaction(function () use ($request, $verifyEmail) {
            // If the token lookup fails, return 404.
            $user = User::query()
                ->where('email_verify_token', $request->input('token'))
                ->firstOrFail();

            try {
                // Verify the user's email, clear their verify token, and save the modified user.
                $verifyEmail->execute($user, true);
            }
            catch (VerifyEmailExpiredException $e) {
                // If the user's token has expired, return 401.
                throw new UnauthorizedHttpException('', 'auth.email_verify_token_expired', $e);
            }
            catch (EmailAlreadyVerifiedException $e) {
                // If the user's email is already verfied, return 409.
                throw new ConflictHttpException('auth.email_already_verified', $e);
            }
        });

        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status' => 'auth.verified',
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(200);
    }
}
