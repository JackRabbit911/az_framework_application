<?php

use Az\Route\Middleware\RouteMatchMiddleware;
use Az\Route\Middleware\RouteMiddleware;
use Az\Route\Middleware\RouteDispatchMiddleware;
use Sys\Middleware\ControllerAttributeMiddleware;

$this->pipe(RouteMatchMiddleware::class);
$this->pipe(RouteMiddleware::class);
// $this->pipe(ControllerAttributeMiddleware::class);
$this->pipe(RouteDispatchMiddleware::class);
