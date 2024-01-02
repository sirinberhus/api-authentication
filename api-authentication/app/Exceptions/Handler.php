<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request as HttpRequest;
use Laravel\Passport\Exceptions\AuthenticationException as ExceptionsAuthenticationException;
use Throwable;
use App\Exceptions\UnauthorizedHttpException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException as ExceptionUnauthorizedHttpException;

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
        if($exception instanceof AuthenticationException) {
            
            return response()->json([
                'message' => 'unauthenticated'
            ], 401);

        }
        dd($exception);
    }
}
