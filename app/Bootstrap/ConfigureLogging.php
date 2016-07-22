<?php

namespace App\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as DefaultLogging;
use Illuminate\Log\Writer;
use Monolog\Handler\LogglyHandler;

class ConfigureLogging extends DefaultLogging
{
    public function configureCustomHandler(Application $app, Writer $log)
    {
        if (! env('LOGGLY_TOKEN')) {
            return;
        }

        $handler = new LogglyHandler(env('LOGGLY_TOKEN'));
        $handler->setTag('laravel');
        $log->getMonolog()->pushHandler($handler);
    }
}
