<?php

use Auth\Middleware\AuthMiddleware;
use App\Http\Controller\Home;
use App\Http\Controller\Test;
use Az\Route\Route;
use HttpSoft\Response\HtmlResponse;
use Sys\Middleware\ControllerAttributeMiddleware;
use Sys\Profiler\Profiler;
use Sys\Profiler\Controller as ProfilerController;

// if (in_array(Profiler::class, config('post_process', null, null, false))) {
//     $this->route->get('/~profiler/{uri?}', ProfilerController::class)
//         ->tokens(['uri' => '.*']);
// }

require_once APPPATH . 'modules/Guide/routes.php';
// require_once APPPATH . 'auth/config/routes.php';

$this->route->controller('{action?}/{param?}', Home::class, 'home')
    // ->pipe(AuthMiddleware::class)
    ;
