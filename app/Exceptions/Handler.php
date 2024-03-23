<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use TypeError;

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
    public function render($request, Throwable $e) : JsonResponse|Response
    {
        if (request()->is('api/*')) {
            if ($e instanceof TypeError) {
                $response = errorResponse('Please check your request and try again', Response::HTTP_INTERNAL_SERVER_ERROR);
            } elseif ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                $error = 'Route not found';
                if ($e instanceof ModelNotFoundException) {
                    $modelName = class_basename($e->getModel());
                    $error = "$modelName not found";
                }
                $response = errorResponse($error, 404);
            }
            elseif ($e instanceof ValidationException) {
                $response = errorResponse($e->validator->errors()->first(), Response::HTTP_UNPROCESSABLE_ENTITY, $e->validator->errors());
            } elseif ($e instanceof QueryException || $e instanceof PDOException) {
                $message = $e->getMessage();
                $message = substr($message, strpos($message, ':') + 1);
                $message = substr($message, 0, strpos($message, ':') + 1);
                $message = substr($message, 0, strpos($message, ':'));
                $response = errorResponse(trim($message), Response::HTTP_UNPROCESSABLE_ENTITY);
            }  elseif ($e instanceof AuthenticationException) {
                $response = errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            }
            elseif ($e instanceof ClientErrorException) {
                return errorResponse($e->getMessage(),$e->getCode());
            }
            else {
                $response = errorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            Log::error($e);

            return $response;
        }

        return parent::render($request, $e);
    }
}
