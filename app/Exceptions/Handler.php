<?php

namespace App\Exceptions;

use App\DTOs\Responses\ApiResponseFailure;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ThrottleRequestsException) {
            if ($request->wantsJson()) {
                return ApiResponseFailure::make(
                    "Please wait a minute before retrying",
                    429
                )->toResponse($request);
            }
        }
        if ($e instanceof \RuntimeException) {
            if ($request->wantsJson()) {
                return ApiResponseFailure::make(
                    $e->getMessage(),
                    $e->getCode())->toResponse($request);
            }
        }
        return parent::render($request, $e);
    }
}
