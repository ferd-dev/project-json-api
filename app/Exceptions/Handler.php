<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
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

    protected function invalidJson($request, ValidationException $exception)
    {
        $title = $exception->getMessage();
        $errors = [];

        foreach ($exception->errors() as $key => $message) {
            $pointer = "/" . str_replace('.', '/', $key);
            $errors[$key] = [
                'title' => $title,
                'detail' => $message[0],
                'source' => [
                    'pointer' => $pointer,
                ],
            ];
        }

        return response()->json([
            'errors' => $errors,
        ], 422);
    }
}
