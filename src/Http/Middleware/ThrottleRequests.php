<?php

namespace ElfSundae\Laravel\Support\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests as BaseMiddleware;

class ThrottleRequests extends BaseMiddleware
{
    /**
     * {@inheritdoc}
     */
    protected function buildResponse($key, $maxAttempts)
    {
        if (app('request')->expectsJson()) {
            return api('操作太频繁，请稍后再试。', 429);
        }

        return parent::buildResponse($key, $maxAttempts);
    }

    /**
     * {@inheritdoc}
     */
    protected function addHeaders(Response $response, $maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        return $response;
    }
}
