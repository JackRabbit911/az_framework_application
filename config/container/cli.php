<?php

use Sys\Template\Template;
use Sys\Template\TemplateFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

return [
    Template::class => fn() => (new TemplateFactory())->create(config('template')),
    'logger' => function ($name, $file, $level) {
        $logger = new Logger($name);
        $logger->setTimezone(new \DateTimeZone(env('tz')));
        $logger->pushHandler(new StreamHandler(WRITABLE . 'logs/' . $file, $level, true, 0777));
        return $logger;
    },
];
