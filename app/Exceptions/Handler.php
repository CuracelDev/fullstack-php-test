<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @param  \Throwable  $exception
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            logger()->error('Model not found exception occurred' . $exception->getMessage());

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_NOT_FOUND,
                'error_type' => 'model_not_found',
                'message' => 'Resource not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            logger()->error('Method not allowed exception occurred' . $exception->getMessage());

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_METHOD_NOT_ALLOWED,
                'error_type' => 'method_not_allowed',
                'message' => 'Method not allowed'
            ], JsonResponse::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof ValidationException) {
            logger()->error('Validation exception occurred' . $exception->getMessage());

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'error_type' => 'validation_error',
                'message' => 'Validation error',
                'errors' => $exception->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->isJson()) {
            logger()->error('Json exception occurred' . $exception->getMessage());

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'error_type' => 'internal_server_error',
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof NotFoundHttpException) {
            logger()->error('Not found exception occurred' . $exception->getMessage());

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_NOT_FOUND,
                'error_type' => 'not_found',
                'message' => 'Resource not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($exception instanceof QueryException) {
            logger()->error('Query exception occurred' . $exception->getMessage());

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'error_type' => 'query_exception',
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof Exception) {
            logger()->error('General exception occurred' . $exception->getMessage(), [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'code' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'error_type' => 'general_exception',
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $exception);
    }
}
