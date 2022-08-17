<?php
/**
 * Created by PhpStorm
 * @Author: wangwin
 * @Date: 2022/8/17
 * @Time: 10:36
 * @Version: 1.0
 */

namespace Wangwin\Weather;


use GuzzleHttp\Client;
use Wangwin\Weather\Kernal\Exceptions\HttpException;
use Wangwin\Weather\Kernal\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;
    protected $guzzleOption = [];

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getHttpClient(): Client
    {
        return new Client($this->guzzleOption);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    public function getWeather($city, string $type = 'base', string $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';
        if (! in_array($format, ['xml', 'json'])) {
            throw  new InvalidArgumentException('format参数不正确'.$format);
        }
        if (! in_array($type, ['base', 'all'])) {
            throw  new InvalidArgumentException('invalid type value '.$type);
        }
        $query = array_filter([
            'key'        => $this->key,
            'city'       => $city,
            'output'     => $format,
            'extensions' => $type,
        ]);
        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Throwable $exception) {
            throw  new HttpException($exception->getMessage(), $exception->getCode(), $exception);
        }


    }
}
