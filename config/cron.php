<?php

use Monolog\Level;

return [
    'debug' => true,
    'status_file' => STORAGE . 'cronstatus.txt',
    'wait_time_queue' => 5,
    'wait_time_tasks' => 10,
    'logger' => [
        'name' => 'e',
        'file' => 'cron_error.log',
        'level' => Level::Warning,
    ],
    'profiler' => [
        'name' => 't',
        'file' => 'cron_profiler.log',
        'level' => Level::Info,
    ],
];
