<?php
/**
 * Created by PhpStorm
 * @Author: wangwin
 * @Date: 2022/8/17
 * @Time: 11:17
 * @Version: 1.0
 */

namespace Wangwin\Weather\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Wangwin\Weather\Weather;

class WeatherTest extends TestCase
{
    public function testGetWeatherWithType()
    {
        $key     = '89dfdec6d0d39b6b7e3be0cbcc8240bf';
        $weather = new Weather($key);
        // $this->expectException(InvalidArgumentException::class);;
        // $this->expectExceptionMessage('66');
        $weather->getWeather('深圳', 'foo');
        // $this->fail('66');

    }

    public function testGetWeather()
    {
        $response = new Response(200, [], '{"success":true}');
        $key      = '27871efe8db4f7c06dbdedd4cbea2142';
        $client   = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo', [
            'query' => [
                'key'        => 'mock-key',
                'city'       => '深圳',
                'output'     => 'json',
                'extensions' => 'base',
            ],
        ])->andReturn($response);
        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame(['success' => true], $w->getWeather('深圳'));
    }

    public function testGetWeatherInfo()
    {
        $key     = '27871efe8db4f7c06dbdedd4cbea2142';
        $weather = new Weather($key);
        $result  = $weather->getWeather('深圳');
        var_dump($result);

    }


    public function testGetHttpClient()
    {

    }
}