<?php

namespace ElfSundae\Laravel\Support\Services\Agent;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class CheckAppClientMiddleware
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
        if (app('client')->is('AppClient')) {
            return $next($request);
        }

        return response('Unauthorized App Client', 403);
    }
}
