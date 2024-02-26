<?php

use Modules\Auth\Http\Middleware\AuthMiddleware;
use App\Http\Controller\Home;
use App\Http\Controller\Test;
use Sys\Middleware\ControllerAttributeMiddleware;
use Sys\Profiler\Profiler;
use Sys\Profiler\Controller as ProfilerController;

if (in_array(Profiler::class, config('post_process', null, null, false))) {
    $this->route->get('/~profiler/{uri?}', ProfilerController::class)
        ->tokens(['uri' => '.*']);
}

require_once APPPATH . 'modules/Guide/routes.php';
require_once APPPATH . 'modules/Auth/config/routes.php';

// $this->route->controller('/test/{action?}/{param?}', Test::class)
//     ->pipe(AuthMiddleware::class, ControllerAttributeMiddleware::class)
//     ;

$this->route->controller('{action?}/{param?}', Home::class, 'home')
    // ->pipe(AuthMiddleware::class)
    ;
