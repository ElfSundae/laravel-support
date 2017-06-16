<?php

namespace ElfSundae\Laravel\Support\Services\Agent;

use Jenssegers\Agent\Agent;
use Illuminate\Support\Fluent;
use ElfSundae\Laravel\Support\Traits\FluentArrayAccess;

/**
 * The app client.
 *
 * @property string os
 * @property string osVersion
 * @property string platform
 * @property string locale
 * @property string app
 * @property string appVersion
 * @property string appChannel
 * @property string network
 * @property string udid
 * @property bool isAppStoreReviewing
 */
class Client extends Fluent
{
    use FluentArrayAccess;

    /**
     * The Agent instance.
     *
     * @var \Jenssegers\Agent\Agent
     */
    protected $agent;

    /**
     * Get the Agent instance.
     *
     * @return \Jenssegers\Agent\Agent
     */
    public function agent()
    {
        return $this->agent;
    }

    /**
     * Set the Agent instance.
     *
     * @param  \Jenssegers\Agent\Agent  $agent
     * @return $this
     */
    public function setAgent(Agent $agent)
    {
        $this->agent = $agent;

        return $this->parseAgent();
    }

    /**
     * Merge new data into the current attributes.
     *
     * @param  array  ...$data
     * @return $this
     */
    public function add(array ...$data)
    {
        $this->attributes = array_replace($this->attributes, ...$data);

        return $this;
    }

    /**
     * Check the version of the given property in the User-Agent.
     *
     * @param  string  $propertyName
     * @return string|float|false
     *
     * @see \Jenssegers\Agent\Agent::version()
     */
    public function version($propertyName, $type = Agent::VERSION_TYPE_STRING)
    {
        $version = $this->agent->version($propertyName, $type);

        return is_string($version) ? str_replace(['_', '+'], '.', $version) : $version;
    }

    /**
     * Check a certain value exists, case insensitived.
     *
     * @param  string  $value
     * @return bool
     */
    public function is($value)
    {
        return in_arrayi($value, $this->attributes) ||
            in_arrayi('is'.$value, array_keys($this->attributes)) ||
            $this->agent->is($value);
    }

    /**
     * Get or check the current app channel.
     *
     * @return string|bool
     */
    public function appChannel()
    {
        $appChannel = $this->get('appChannel');

        if (func_num_args() > 0) {
            $checks = is_array(func_get_arg(0)) ? func_get_arg(0) : func_get_args();

            return $appChannel ? in_arrayi($appChannel, $checks) : false;
        }

        return $appChannel;
    }

    /**
     * Set the User-Agent to be used.
     *
     * @param  string  $userAgent
     * @return $this
     */
    public function setUserAgent($userAgent = null)
    {
        $this->agent->setUserAgent($userAgent);

        return $this->parseAgent();
    }

    /**
     * Parse Agent information.
     *
     * @return $this
     */
    protected function parseAgent()
    {
        return $this->add(
            $this->parseCommonClient(),
            $this->parseAppClient()
        );
    }

    /**
     * Parse common client.
     *
     * @return array
     */
    protected function parseCommonClient()
    {
        $info = [
            'os' => $this->agent->platform(),
            'osVersion' => $this->version($this->agent->platform()),
            'platform' => $this->agent->device(),
            'locale' => head($this->agent->languages()),
        ];

        if ($this->agent->is('iOS')) {
            $info['os'] = 'iOS';
        }

        if ($this->agent->is('AndroidOS')) {
            $info['os'] = 'Android';
        }

        if (is_string($this->version('MicroMessenger'))) {
            $info['isWechat'] = true;
        } else {
            unset($info['isWechat']);
        }

        return array_filter($info);
    }

    /**
     * Parse app client from the User-Agent.
     *
     * @example `Mozilla/5.0 (iPhone; CPU iPhone OS 8_4 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Mobile/12H143 _ua(eyJuZXQiOiJXaUZpIiwib3MiOiJpT1MiLCJhcHBWIjoiMC4xLjIiLCJvc1YiOiI4LjQiLCJhcHAiOiJndXBpYW8iLCJhcHBDIjoiRGVidWciLCJ0ZGlkIjoiaDNiYjFmNTBhYzBhMzdkYmE4ODhlMTgyNjU3OWJkZmZmIiwiYWNpZCI6IjIxZDNmYmQzNDNmMjViYmI0MzU2ZGEyMmJmZjUxZDczZjg0YWQwNmQiLCJsb2MiOiJ6aF9DTiIsInBmIjoiaVBob25lNywxIn0)`
     *
     * @return array
     */
    protected function parseAppClient()
    {
        $data = $this->getAppClientAttributes(
            $this->getAppClientData($this->agent->getUserAgent())
        );

        if (! $data) {
            $this->resetAppClientAttributes();
        }

        return $data;
    }

    /**
     * Get app client information from the User-Agent.
     *
     * @param  string  $userAgent
     * @return array
     */
    protected function getAppClientData($userAgent)
    {
        if (preg_match('#client\((.+)\)#is', $userAgent, $matches)) {
            if ($info = json_decode(urlsafe_base64_decode($matches[1]), true)) {
                if (is_array($info) && ! empty($info)) {
                    return $info;
                }
            }
        }

        return [];
    }

    /**
     * Get app client attributes.
     *
     * @param  array  $info
     * @return array
     */
    protected function getAppClientAttributes($info)
    {
        $info = array_filter($info);
        $data = [];

        if (
            ($data['os'] = array_get($info, 'os')) &&
            ($data['osVersion'] = array_get($info, 'osV')) &&
            ($data['platform'] = array_get($info, 'pf')) &&
            ($data['locale'] = array_get($info, 'loc')) &&
            ($data['app'] = array_get($info, 'app')) &&
            ($data['appVersion'] = array_get($info, 'appV')) &&
            ($data['appChannel'] = array_get($info, 'appC')) &&
            ($data['network'] = array_get($info, 'net')) &&
            ($data['udid'] = array_get($info, 'udid'))
        ) {
            if ($data['os'] === 'iPhone OS') {
                $data['os'] = 'iOS';
            }

            $data['isAppClient'] = true;

            return array_filter($data);
        }

        return [];
    }

    /**
     * Reset app client attributes.
     */
    protected function resetAppClientAttributes()
    {
        unset(
            $this->attributes['app'],
            $this->attributes['appVersion'],
            $this->attributes['appChannel'],
            $this->attributes['network'],
            $this->attributes['udid'],
            $this->attributes['isAppClient']
        );
    }

    /**
     * Handle dynamic calls to the Agent instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->agent, $method], $parameters);
    }
}
