<?php

namespace ElfSundae\Laravel\Support\Exceptions;

use Exception;
use Psr\Log\LoggerInterface;
use ElfSundae\Laravel\Api\Http\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use ElfSundae\Laravel\Api\Exceptions\ApiResponseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class Handler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldntReport($e)) {
            return;
        }

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (Exception $ex) {
            throw $e; // throw the original exception
        }

        $requestInfo = $this->getRequestInfo();

        $logger->error($e, $requestInfo);

        if (method_exists($this, 'notify')) {
            $this->notify($e, $requestInfo);
        }
    }

    /**
     * Get the request info.
     *
     * @return array
     */
    protected function getRequestInfo()
    {
        $request = $this->container->make('request');

        $info = [
            'IP' => $request->ips(),
            'UserAgent' => $request->server('HTTP_USER_AGENT'),
            'URL' => $request->fullUrl(),
        ];

        if ($this->container->runningInConsole()) {
            $info['Command'] = implode(' ', $request->server('argv', []));
        }

        return $info;
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
        if ($e instanceof MaintenanceModeException) {
            return $this->renderForMaintenanceMode($request, $e);
        } elseif ($e instanceof ApiResponseException) {
            return $e->getResponse();
        }

        return parent::render($request, $e);
    }

    /**
     * Render for MaintenanceModeException.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException  $e
     * @return \Illuminate\Http\Response
     */
    protected function renderForMaintenanceMode($request, MaintenanceModeException $e)
    {
        if ($request->expectsJson()) {
            return $this->createApiResponse($e->getMessage() ?: '服务器维护中，请稍后重试。', 503, $e);
        }

        return $this->toIlluminateResponse($this->renderHttpException($e), $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $e
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $e)
    {
        if ($request->expectsJson()) {
            return $this->createApiResponse('认证失败，请先登录。', 401, $e);
        }

        return redirect()->guest('login');
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($request->expectsJson()) {
            $message = implode("\n", array_flatten($e->validator->errors()->getMessages()));

            return $this->createApiResponse($message, 422, $e);
        }

        return parent::convertValidationExceptionToResponse($e, $request);
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        if ($this->container->make('request')->expectsJson()) {
            $status = $e->getStatusCode();
            $message = $e->getMessage();

            if (empty($message)) {
                if (401 === $status) {
                    $message = '认证失败，请先登录';
                } elseif (403 === $status) {
                    $message = '无权操作，拒绝访问';
                } elseif (404 === $status) {
                    $message = '404 Not Found';
                } else {
                    $message = 'Error '.$status;
                }
            }

            return $this->createApiResponse($message, $status, $e);
        }

        return parent::renderHttpException($e);
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        if (request()->expectsJson() && ! $this->container->make('config')->get('app.debug')) {
            return $this->convertExceptionToApiResponse($e);
        }

        return parent::convertExceptionToResponse($e);
    }

    /**
     * Create an API response for the given exception.
     *
     * @param  \Exception  $e
     * @return \ElfSundae\Laravel\Api\Http\ApiResponse
     */
    protected function convertExceptionToApiResponse(Exception $e)
    {
        $code = $this->isHttpException($e) ? $e->getStatusCode() : $e->getCode();

        return $this->createApiResponse($e->getMessage(), $code, $e);
    }

    /**
     * Create an API response.
     *
     * @param  mixed  $message
     * @param  int  $code
     * @param  \Exception  $e
     * @return \ElfSundae\Laravel\Api\Http\ApiResponse
     */
    protected function createApiResponse($message = null, $code = null, Exception $e)
    {
        $response = new ApiResponse($message, $code);

        if ($response->getCode() === $response::successCode()) {
            $response->setCode(-1 * $response->getCode());
        }

        if (empty($response->getMessage())) {
            $response->setMessage('Error #'.$response->getCode());
        }

        return $response->withException($e);
    }
}
