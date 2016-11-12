<?php

namespace Delivery\Exceptions;


use Exception;
use Asm89\Stack\CorsService;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Psr\Log\LoggerInterface;

class Handler extends ExceptionHandler
{

    private $corsService;

    public function __construct(LoggerInterface $log, CorsService $corsService){
        parent::__construct($log);
        $this->corsService = $corsService;
    }


    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        OAuthException::class,
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
        if($e instanceof ModelNotFoundException){
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }elseif($e instanceof OAuthException){
            $response = response()->json([
                'error' => $e->errorType,
                'error_description' => $e->getMessage()
            ], $e->httpStatusCode, $e->getHttpHeaders());
            return $this->corsService->addActualRequestHeaders($response, $request);
        }

        return parent::render($request, $e);
    }
}
