<?php

namespace ElfSundae\Laravel\Support\Services\Mob;

use ElfSundae\HttpClient;
use ElfSundae\Laravel\Api\Exceptions\InvalidInputException;
use ElfSundae\Laravel\Api\Exceptions\ActionFailureException;

class Sms
{
    /**
     * Mob SMS verification.
     *
     * @see http://wiki.mob.com/webapi2-0/
     *
     * @param  array  $credentials  `['phone', 'code', 'zone']`
     * @return void
     *
     * @throws \ElfSundae\Laravel\Api\Exceptions\ApiResponseException
     */
    public static function verify($credentials = [])
    {
        $response = (new HttpClient('https://webapi.sms.mob.com/'))
            ->formParams(array_merge($credentials, [
                'appkey' => config('services.mobsms.key'),
            ]))
            ->fetchJson('/sms/verify', 'POST');

        if (! is_array($response)) {
            throw new ActionFailureException('短信网关请求失败');
        }

        $status = (int) array_get($response, 'status', -1);

        switch ($status) {
            case 200:
            return;

            case 405:
            case 406:
            case 474:
            throw new ActionFailureException('Server Error #'.$status);
            case 457:
            throw new InvalidInputException('请填写正确的手机号', 10);
            case 466:
            throw new InvalidInputException('验证码不能为空');
            case 467:
            throw new InvalidInputException('请求验证码过于频繁，请稍后再试');
            default:
            throw new InvalidInputException('验证码无效，请重新获取');
        }
    }
}
