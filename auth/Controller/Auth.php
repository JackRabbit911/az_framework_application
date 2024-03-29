<?php

namespace Auth\Controller;

use Auth\Model\TokenAuth;
use HttpSoft\Response\RedirectResponse;
use Az\Route\Route;
use Auth\Middleware\AuthGuardMiddleware;
use Auth\Middleware\AuthValidation;
use Auth\Middleware\GuestGuardMiddleware;

final class Auth extends AuthAbstract
{
    public function __invoke()
    {
        $ref = $this->setReferer();

        if ($this->user !== null) {
            return new RedirectResponse($ref);
        }

        return $this->tpl->render('@auth/auth');
    }

    #[Route(methods: 'post', pipe: AuthValidation::class)]
    public function check(TokenAuth $tokenAuth)
    {
        $user = $this->model->getUser();

        $this->session->user_id = $user->id;
        $this->session->regenerate(true);

        $tokenAuth->remember('remember', $user->id);

        return new RedirectResponse($this->getReferer());
    }

    #[Route(unPipe: GuestGuardMiddleware::class, pipe: AuthGuardMiddleware::class)]
    public function logOut(TokenAuth $tokenAuth)
    {
        $this->session->destroy();
        $tokenAuth->forget($this->request->getCookieParams());
        
        return new RedirectResponse($this->getReferer());
    }
}
