<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Notifications\SendEmailVerifyNotification;
use App\Http\Requests\Auth\ResendVerifyEmailRequest;
use App\Http\Resources\BaseResource;
use Domain\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ResendVerifyEmailController
{
    public function __invoke(
        ResendVerifyEmailRequest $request,
        SendEmailVerifyNotification $sendEmail
    ): JsonResponse
    {
        DB::transaction(function () use ($request, $sendEmail) {
            // If there's already an account verified with this email, we don't want to send another verification.
            // Note: We always return 200 here to prevent account enumeration via this route.
            $user = User::query()
                ->where('email', $request->input('email'))
                ->orderBy('email_verified_at', 'desc')
                ->first();

            if ($user && ! $user->isEmailVerified()) {
                // Set the user's email verify token and send them a verification email.
                $sendEmail->execute($user, true);
            }
        });

        return (new BaseResource)
            ->toResponse($request);
    }
}
