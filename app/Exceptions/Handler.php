<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

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
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return JsonResponse|Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            return response()->json([
                "time" => Carbon::now()->toDateTimeString(),
                "message" => $exception->getMessage()
            ], '403');
        }
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                "time" => Carbon::now()->toDateTimeString(),
                "message" => "Data not found"
            ], '404');
        }

//        if ($request->expectsJson()) {
//            return response()->json(["message" => $exception->getMessage()], '404');
//        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            "time" => Carbon::now()->toDateTimeString(),
            "message" => $exception->getMessage()
        ], '401');
    }
}
