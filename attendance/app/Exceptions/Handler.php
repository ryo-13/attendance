<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use App\Providers\ResponseApiServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $e)
    {
        $e = $this->prepareException($e);
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            $status  = Response::HTTP_UNAUTHORIZED;
            $message = Response::$statusTexts[$status];
            $errors  = [];
        } elseif ($e instanceof ValidationException) {
            $status  = $e->status;
            $message = Response::$statusTexts[$status];
            $errors  = $e->errors();
        } elseif ($this->isHttpException($e)) {
            $status  = $e->getStatusCode();
            $message = (isset(Response::$statusTexts[$status])) ? Response::$statusTexts[$status] : '';
            $errors  = [];
        } else {
            $status  = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = 'Server Error';
            $errors  = [];
        }
        // ResponseApiServiceProviderが実行される前にエラーが発生した場合の対応
        if (!method_exists(response(), 'error')) {
            $app = app();
            $provide = new ResponseApiServiceProvider($app);
            $provide->boot();
        }

        return response()->error($message, $errors, $status);
    }
}
