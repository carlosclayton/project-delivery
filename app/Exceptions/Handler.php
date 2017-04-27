<?php

namespace Delivery\Exceptions;


use Asm89\Stack\CorsService;

///use Barryvdh\Cors\Stack\CorsService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class Handler extends ExceptionHandler
{

    private $corsService;
    public function __construct(LoggerInterface $log, CorsService $corsService)
    {
        parent::__construct($log);
        $this->corsService = $corsService;
    }


    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        //dd($e);
        //$response = parent::render($request, $e);
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof OAuthException) {

            $response = response()->json([
                'error' => $e->errorType,
                'error_description' => $e->getMessage()
            ], 400, $e->getHttpHeaders());
            return $this->corsService->addActualRequestHeaders($response, $request);
        } else {
            return parent::render($request, $e);
        }

    }
}
