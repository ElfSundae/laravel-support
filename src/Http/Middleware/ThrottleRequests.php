<?php

namespace ElfSundae\Support\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests as Middleware;

class ThrottleRequests extends Middleware
{
    /**
     * {@inheritdoc}
     */
    protected function getHeaders($maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        return [];
    }
}
