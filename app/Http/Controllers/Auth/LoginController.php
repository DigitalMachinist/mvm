<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\EmailNotVerifiedException;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Domain\Users\User;
use Domain\Users\Actions\LoginUser;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController
{
    public function __invoke(
        LoginRequest $request,
        LoginUser $loginUser
    ): JsonResponse
    {
        // Prefer the user at the given email address that has a verified email.
        $user = User::query()
            ->where('email', $request->input('email'))
            ->orderBy('email_verified_at', 'desc')
            ->first();

        if (! $user) {
            throw new UnauthorizedHttpException('', 'auth.invalid_credentials');
        }

        try {
            $token = $loginUser
                ->execute(
                    $user,
                    $request->input('password')
                );
        }
        catch (InvalidCredentialsException $e) {
            throw new UnauthorizedHttpException('', 'auth.invalid_credentials');
        }
        catch (EmailNotVerifiedException $e) {
            throw new AccessDeniedHttpException('auth.email_not_verified');
        }
        catch (JWTException $e) {
            throw new HttpException(500, 'auth.could_not_create_token');
        }

        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'status' => 'auth.logged_in',
                    'token'  => $token,
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(200);
    }
}
