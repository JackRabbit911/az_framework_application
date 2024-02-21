<?php

use Modules\Auth\Http\Controller\Auth;
use Modules\Auth\Http\Controller\Register;
use Modules\Auth\Http\Controller\Restore;
use Modules\Auth\Http\Middleware\AuthMiddleware;
use Modules\Auth\Http\Middleware\GuestGuardMiddleware;
use Az\Validation\Middleware\CsrfMiddleware;


$this->route->group('/auth', function () {
    $this->route->controller('/{action?}', Auth::class, 'auth');
    $this->route->controller('/register/{action?}/{code?}', Register::class, 'register');
    $this->route->controller('/restore/{action?}/{code?}', Restore::class, 'restore');
    $this->route->pipe(AuthMiddleware::class, GuestGuardMiddleware::class, CsrfMiddleware::class);
    $this->route->methods('get');
});
