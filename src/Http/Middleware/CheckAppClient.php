<?php

namespace ElfSundae\Laravel\Support\Http\Middleware;

use Closure;
use ElfSundae\Laravel\Agent\Client;
use ElfSundae\Laravel\Api\Exceptions\ApiResponseException;

class CheckAppClient
{
    /**
     * The agent client instance.
     *
     * @var \ElfSundae\Laravel\Agent\Client
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param  \ElfSundae\Laravel\Agent\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->client->is('AppClient')) {
            throw new ApiResponseException('Unauthorized Client', 403);
        }

        if (
            $this->client->is('iOS') &&
            $this->client->appChannel('App Store') &&
            $this->client->get('appVersion') === config('var.ios.app_store_reviewing_version')
        ) {
            $this->client->set('isAppStoreReviewing', true);
        }

        return $next($request);
    }
}
