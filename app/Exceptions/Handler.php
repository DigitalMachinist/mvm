<?php

namespace App\Exceptions;

use App\Http\Resources\BaseResource;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function context()
    {
        try {
            return array_filter([
                'user_id' => auth()::id(),
                'email'   => optional(auth()::user())->email,
            ]);
        }
        catch (Throwable $e) {
            return [];
        }
    }

    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $e)
    {
        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status'  => 'validation.failed',
                    'message' => $e->getMessage(),
                    'errors'  => $e->errors(),
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(422);
    }

    protected function unauthenticated($request, AuthenticationException $e)
    {
        return (new BaseResource)
            ->additional([
                'meta' => [
                    'status'  => 'auth.failed',
                    'message' => $e->getMessage(),
                ],
            ])
            ->toResponse($request)
            ->setStatusCode(401);
    }

    protected function prepareJsonResponse($request, Exception $e)
    {
        return (new BaseResource)
            ->additional([
                'meta' => array_merge(
                    $this->convertExceptionToArray($e),
                    [
                        'status'  => $e->getMessage(),
                    ]
                ),
            ])
            ->toResponse($request)
            ->setStatusCode(
                $this->isHttpException($e)
                    ? $e->getStatusCode()
                    : 500
            );
    }

    protected function convertExceptionToArray(Exception $e)
    {
        return config('app.debug')
            ? [
                'message'   => $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage(),
                'exception' => get_class($e),
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'trace'     => collect($e->getTrace())
                    ->map(function ($trace) {
                        return Arr::except($trace, ['args']);
                    })
                    ->all(),
            ]
            : [
                'message' => $this->isHttpException($e)
                    ? ($e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage())
                    : 'Server Error',
            ];
    }
}
