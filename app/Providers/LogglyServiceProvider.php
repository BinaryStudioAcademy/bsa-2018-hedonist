<?php

namespace Hedonist\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\LogglyHandler;
use Illuminate\Support\Facades\Config;
use Monolog\Logger;

class LogglyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production' || env('APP_ENV') === 'staging') {
            $this->registerLoggly();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function registerLoggly()
    {
        $key = Config::get('services.loggly.key');

        if (empty($key)) {
            throw new \InvalidArgumentException('Loggly key not configured');
        }

        $tag = Config::get('services.loggly.tag');

        $handler = new LogglyHandler(
            $key,
            Logger::INFO
        );

        $handler->setTag($tag);

        $monologLogger = Log::getLogger();

        $monologLogger->pushHandler($handler);
    }
}
