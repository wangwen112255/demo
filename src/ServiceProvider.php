<?php
/**
 * Created by PhpStorm
 * @Author: wangwin
 * @Date: 2022/8/17
 * @Time: 14:56
 * @Version: 1.0
 */

namespace Wangwin\Weather;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
// 其中我们设置了 $defer 属性为 true，并且添加了方法 provides，这是 Laravel 扩展包的延迟注册方式，它不会在框架启动就注册，而是当你调用到它的时候才会注册。
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Weather::class, function () {
            return new Weather(config('services.weather.key'));
        });

        $this->app->alias(Weather::class, 'weather');
    }

    public function provides()
    {
        return [Weather::class, 'weather'];
    }
}