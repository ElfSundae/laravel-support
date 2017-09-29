<?php

namespace ElfSundae\Laravel\Support\Http\Middleware;

use Closure;
use ElfSundae\Laravel\Agent\AgentClient;
use ElfSundae\Laravel\Api\Exceptions\ApiResponseException;

class CheckAppClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! AgentClient::is('AppClient')) {
            throw new ApiResponseException('Unauthorized Client', 403);
        }

        if (
            AgentClient::is('iOS') &&
            AgentClient::appChannel('App Store') &&
            AgentClient::get('appVersion') === config('var.ios.app_store_reviewing_version')
        ) {
            AgentClient::set('isAppStoreReviewing', true);
        }

        return $next($request);
    }
}
