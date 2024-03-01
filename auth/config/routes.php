<?php

use Auth\Controller\Auth;
use Auth\Controller\Register;
use Auth\Controller\Restore;
use Auth\Middleware\AuthMiddleware;
use Auth\Middleware\GuestGuardMiddleware;
use Az\Validation\Middleware\CsrfMiddleware;


$this->route->group('/auth', function () {
    $this->route->controller('/{action?}', Auth::class, 'auth');
    $this->route->controller('/register/{action?}/{code?}', Register::class, 'register');
    $this->route->controller('/restore/{action?}/{code?}', Restore::class, 'restore');
    $this->route->pipe(AuthMiddleware::class, GuestGuardMiddleware::class, CsrfMiddleware::class);
    $this->route->methods('get');
});
