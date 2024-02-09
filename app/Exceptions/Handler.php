<?php

namespace App\Exceptions;

use App\Concerns\UsesCustomResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use UsesCustomResponse;

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
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($this->container->bound('log') && $e->getCode() >= 500) {
                //
            }
        });
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        return match (true) {
            $e instanceof NotFoundHttpException => $this->error(
                message: 'The requested URL is invalid',
                statusCode: Response::HTTP_NOT_FOUND
            ),
            $e instanceof MethodNotAllowedHttpException => $this->error(
                $e->getMessage(),
                Response::HTTP_METHOD_NOT_ALLOWED
            ),
            default => parent::render($request, $e)
        };
    }

    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return $request->expectsJson();
    }

    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return new JsonResponse(
            ['success' => false, 'message' => $exception->getMessage(), 'errors' => $exception->errors()],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
