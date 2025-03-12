<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Always return JSON response for API routes
        if ($request->is('api/*')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        // For web routes, try to redirect to login if it exists
        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated.'], 401)
            : redirect()->guest($request->expectsJson() ? null : '/login');
    }
}