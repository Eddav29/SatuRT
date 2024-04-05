<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof ModelNotFoundException | $exception instanceof NotFoundHttpException) {
                return response()->json(['code' => '404', 'message' => $exception->getMessage(), 'timestamp' => now()], 404);
            } elseif ($exception instanceof HttpException) {
                return response()->json(['code' => $exception->getStatusCode(), 'message' => $exception->getMessage(), 'timestamp' => now()], $exception->getStatusCode());
            } else if ($exception instanceof AuthenticationException) {
                return response()->json(['code' => 401, 'message' => $exception->getMessage(), 'timestamp' => now()], 401);
            } else if ($exception instanceof ValidationException) {
                return response()->json(['code' => 400, 'message' => 'Bad Request', 'timestamp' => now(), 'errors' => $exception->errors()], 400);
            } else {
                return response()->json(['code' => 500, 'message' => 'Internal Server Error', 'timestamp' => now()], 500);
            }
        }

        return parent::render($request, $exception);
    }
}
