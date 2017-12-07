<?php

namespace ElfSundae\Laravel\Support;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

class Helper
{
    /**
     * Get file extension for MIME type.
     *
     * @param  string  $mimeType
     * @param  string  $prefix
     * @return string|null
     */
    public static function fileExtensionForMimeType($mimeType, $prefix = '')
    {
        if ($extension = ExtensionGuesser::getInstance()->guess($mimeType)) {
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }

            return $prefix.$extension;
        }
    }

    /**
     * Convert an iOS platform to the device model name.
     *
     * @see https://www.theiphonewiki.com/wiki/Models
     * @see https://support.hockeyapp.net/kb/client-integration-ios-mac-os-x-tvos/ios-device-types
     *
     * @param  string  $platform
     * @return string
     */
    public static function iDeviceModel($platform)
    {
        static $iDeviceModels = null;

        if (is_null($iDeviceModels)) {
            $iDeviceModels = [
                'i386' => 'Simulator',
                'x86_64' => 'Simulator',

                'iPhone1,1' => 'iPhone',
                'iPhone1,2' => 'iPhone 3G',
                'iPhone2,1' => 'iPhone 3GS',
                'iPhone3,1' => 'iPhone 4',
                'iPhone3,2' => 'iPhone 4',
                'iPhone3,3' => 'iPhone 4',
                'iPhone4,1' => 'iPhone 4S',
                'iPhone5,1' => 'iPhone 5',
                'iPhone5,2' => 'iPhone 5',
                'iPhone5,3' => 'iPhone 5c',
                'iPhone5,4' => 'iPhone 5c',
                'iPhone6,1' => 'iPhone 5s',
                'iPhone6,2' => 'iPhone 5s',
                'iPhone7,1' => 'iPhone 6 Plus',
                'iPhone7,2' => 'iPhone 6',
                'iPhone8,1' => 'iPhone 6s',
                'iPhone8,2' => 'iPhone 6s Plus',
                'iPhone8,4' => 'iPhone SE',
                'iPhone9,1' => 'iPhone 7',
                'iPhone9,2' => 'iPhone 7 Plus',
                'iPhone9,3' => 'iPhone 7',
                'iPhone9,4' => 'iPhone 7 Plus',

                'iPod1,1' => 'iPod touch',
                'iPod2,1' => 'iPod touch 2G',
                'iPod3,1' => 'iPod touch 3G',
                'iPod4,1' => 'iPod touch 4G',
                'iPod5,1' => 'iPod touch 5G',
                'iPod7,1' => 'iPod touch 6G',

                'iPad1,1' => 'iPad',
                'iPad2,1' => 'iPad 2',
                'iPad2,2' => 'iPad 2',
                'iPad2,3' => 'iPad 2',
                'iPad2,4' => 'iPad 2',
                'iPad2,5' => 'iPad mini',
                'iPad2,6' => 'iPad mini',
                'iPad2,7' => 'iPad mini',
                'iPad3,1' => 'iPad 3',
                'iPad3,2' => 'iPad 3',
                'iPad3,3' => 'iPad 3',
                'iPad3,4' => 'iPad 4',
                'iPad3,5' => 'iPad 4',
                'iPad3,6' => 'iPad 4',
                'iPad4,1' => 'iPad Air',
                'iPad4,2' => 'iPad Air',
                'iPad4,3' => 'iPad Air',
                'iPad4,4' => 'iPad mini 2',
                'iPad4,5' => 'iPad mini 2',
                'iPad4,6' => 'iPad mini 2',
                'iPad4,7' => 'iPad mini 3',
                'iPad4,8' => 'iPad mini 3',
                'iPad4,9' => 'iPad mini 3',
                'iPad5,1' => 'iPad mini 4',
                'iPad5,2' => 'iPad mini 4',
                'iPad5,3' => 'iPad Air 2',
                'iPad5,4' => 'iPad Air 2',
                'iPad6,3' => 'iPad Pro',
                'iPad6,4' => 'iPad Pro',
                'iPad6,7' => 'iPad Pro',
                'iPad6,8' => 'iPad Pro',

                'AppleTV2,1' => 'Apple TV 2G',
                'AppleTV3,1' => 'Apple TV 3G',
                'AppleTV3,2' => 'Apple TV 3G',
                'AppleTV5,3' => 'Apple TV 4G',

                'Watch1,1' => 'Apple Watch',
                'Watch1,2' => 'Apple Watch',
                'Watch2,6' => 'Apple Watch Series 1',
                'Watch2,7' => 'Apple Watch Series 1',
                'Watch2,3' => 'Apple Watch Series 2',
                'Watch2,4' => 'Apple Watch Series 2',
            ];
        }

        return $iDeviceModels[$platform] ?? $platform;
    }

    /**
     * Get the mail homepage.
     *
     * @param  string  $address
     * @return string|null
     */
    public static function mailHomepage($address)
    {
        static $mailHomepages = null;

        if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
            if (is_null($mailHomepages)) {
                $mailHomepages = [
                    'gmail.com' => 'https://mail.google.com',
                    'yahoo.com' => 'https://mail.yahoo.com',
                    'outlook.com' => 'https://outlook.live.com',
                    'qq.com' => 'https://mail.qq.com',
                    'vip.qq.com' => 'https://mail.qq.com',
                    '163.com' => 'http://mail.163.com',
                    '126.com' => 'http://www.126.com',
                    'yeah.net' => 'http://www.yeah.net',
                    'sina.com' => 'https://mail.sina.com.cn',
                    'sina.cn' => 'https://mail.sina.com.cn',
                    'vip.sina.com' => 'https://mail.sina.com.cn',
                    'sohu.com' => 'https://mail.sohu.com',
                    'vip.sohu.com' => 'https://vip.sohu.com',
                    'aliyun.com' => 'https://mail.aliyun.com',
                    'tom.com' => 'http://mail.tom.com',
                    '139.com' => 'http://mail.10086.cn',
                    'wo.cn' => 'https://mail.wo.cn',
                    '189.cn' => 'https://mail.189.cn',
                ];
            }

            $domain = strtolower(Str::after($address, '@'));

            return $mailHomepages[$domain] ?? 'http://'.$domain;
        }
    }

    /**
     * Encrypt ASCII string via XOR.
     *
     * @param  string  $text
     * @param  string|null  $key
     * @return string
     */
    public static function sampleEncrypt($text, $key = null)
    {
        $text = (string) $text;
        if (is_null($key)) {
            $key = app('encrypter')->getKey();
        }

        // 生成随机字符串
        $random = str_random(strlen($text));

        // 按字符拼接：随机字符串 + 随机字符串异或原文
        $tmp = static::sampleEncryption($text, $random, function ($a, $b) {
            return $b.($a ^ $b);
        });

        // 异或 $tmp 和 $key
        $result = static::sampleEncryption($tmp, $key);

        return urlsafe_base64_encode($result);
    }

    /**
     * Decrypt string via XOR.
     *
     * @param  string  $text
     * @param  string|null  $key
     * @return string
     */
    public static function sampleDecrypt($text, $key = null)
    {
        if (is_null($key)) {
            $key = app('encrypter')->getKey();
        }

        $tmp = static::sampleEncryption(urlsafe_base64_decode($text), $key);
        $tmpLength = strlen($tmp);
        $result = '';
        for ($i = 0; $i < $tmpLength, ($i + 1) < $tmpLength; $i += 2) {
            $result .= $tmp[$i] ^ $tmp[$i + 1];
        }

        return $result;
    }

    /**
     * Do a sample XOR encryption.
     *
     * @param  string  $text
     * @param  string  $key
     * @param  \Closure|null  $callback `($a, $b, $index)`
     * @return string
     */
    protected static function sampleEncryption($text, $key, $callback = null)
    {
        // 对 $text 和 $key 的每个字符进行运算。
        // $callback 为 null 时默认进行异或运算。
        // $callback 参数： 第 i 位 $text, 第 i 位 $key, 下标 i
        // $callback 返回 false 时，结束字符循环.

        $text = (string) $text;
        $key = (string) $key;
        $keyLength = strlen($key);
        if (is_null($callback)) {
            $callback = function ($a, $b) {
                return $a ^ $b;
            };
        }

        $result = '';
        $textLength = strlen($text);
        for ($i = 0; $i < $textLength; $i++) {
            $tmp = $callback($text[$i], $key[$i % $keyLength], $i);
            if (false === $tmp) {
                break;
            }
            $result .= $tmp;
        }

        return $result;
    }

    /**
     * Fake current agent client to an app client.
     *
     * @param  array  $client
     * @return void
     */
    public static function fakeAppClient(array $client)
    {
        app()->resolving('agent.client', function ($agent, $app) use ($client) {
            if ($agent->is('AppClient')) {
                return;
            }

            $client = urlsafe_base64_encode(json_encode($client));

            $agent->setUserAgent(
                $app['request']->header('User-Agent')." client($client)"
            );
        });
    }

    /**
     * Set faked api token for the current request.
     *
     * @param  string|null  $appKey
     * @return void
     */
    public static function fakeApiToken($appKey = null)
    {
        app()->rebinding('request', function ($app, $request) use ($appKey) {
            if ($request->hasHeader('X-API-TOKEN') || $request->has('_token')) {
                return;
            }

            $appKey = $appKey ?: app('api.client')->defaultAppKey();

            foreach (app('api.token')->generateDataForKey($appKey) as $key => $value) {
                $request->headers->set('X-API-'.strtoupper($key), $value);
            }
        });
    }
}
