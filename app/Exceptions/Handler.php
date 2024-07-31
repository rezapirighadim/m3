<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return bool|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, \Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->NotFoundExceptionMessage($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * @param $request
     * @param Exception $exception
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function NotFoundExceptionMessage($request, Exception $exception)
    {
        return $request->expectsJson()
            ? new JsonResponse(responseStructure('fail',[],'invalid request' , 'not fond') , 404)
            : parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(responseStructure('fail',[] , 'امکان دسترسی برای شما وجود ندارد.' , 'forbidden access'), 401)
            : redirect()->guest(route('login'));
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json( responseStructure('fail' , [] , 'اطلاعات وارد شده نامعتبر است .' , $exception->errors()) , $exception->status);
    }
}
