<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
      if ($request->expectsJson() || $request->is('api/*')) {
  			if ($e instanceof UnauthorizedHttpException) {
  				switch (get_class($e->getPrevious())) {
  				case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
  					return response()->json([
  						'status' => 'error',
  						'message' => 'Token has expired',
  					], $e->getStatusCode());
  				case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
  					return response()->json([
  						'status' => 'error',
  						'message' => 'Token is invalid',
  					], $e->getStatusCode());
  				case \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class:
  					return response()->json([
  						'status' => 'error',
  						'message' => 'Token has been blacklisted',
  					], $e->getStatusCode());
  				default:
          return response()->json([
            'status' => 'error',
            'message' => 'Token Not Provided or something went wrong',
          ], $e->getStatusCode());
  					break;
  				}
  			}
		  }
      return parent::render($request, $e);
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($this->isHttpException($e)) {

        }

        // Default system error page.
        return response(view('errors.500'), 500);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
