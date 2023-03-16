<?php

namespace App\Exceptions;

use App\Http\Controllers\Clients\ErrorController;
use App\Http\Controllers\Manager\ErrorController as ManagerErrorController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * @throws \Throwable
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
        if ($this->isHttpException($exception)) {
            
            if (!$request->expectsJson()) {
                $code = $exception->getStatusCode();
                if (get_sys_subdomain() == 'manager' && ($code == 404 || $code == 403)) {
                    return response(app(ManagerErrorController::class)->showError($request, $code), $code);
                } else if ($code == 404 && get_owner_id()) {
                    if(__WEBTYPE__ == __WEBTYPE__WORDPRESS__) return response(view('wp.client'));
                    /**
                     * @var ErrorController
                     */
                    $errorController = app(ErrorController::class);
                    if($errorController->checkModuleExists($code)) return response($errorController->reportError($request, $code), $code);
                }
                
            }
        }
        return parent::render($request, $exception);
    }
}

