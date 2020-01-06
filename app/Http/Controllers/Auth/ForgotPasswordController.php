<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Notifications\SendPasswordResetNotification;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Resources\BaseResource;
use Domain\Users\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController
{
    public function __invoke(
        ForgotPasswordRequest $request,
        SendPasswordResetNotification $sendEmail
    ): JsonResponse
    {
        DB::transaction(function () use ($request, $sendEmail) {
            // If there's already an account verified with this email, we prefer sending to that user.
            // Note: We always return 200 here to prevent account enumeration via this route.
            $user = User::query()
                ->where('email', $request->input('email'))
                ->orderBy('email_verified_at', 'desc')
                ->first();

            if ($user) {
                // Set the user's password reset token and send them a password reset email.
                $sendEmail->execute($user, true);
            }
        });

        return (new BaseResource)
            ->toResponse($request);
    }
}
