<?php

namespace Auth\Controller;

use App\Listener\MailByData;
use Auth\User;
use Az\Route\Route;
use Auth\Middleware\RegisterValidation;
use Auth\Middleware\RegisterTokenMiddleware;
use Sys\Middleware\ControllerAttributeMiddleware;

final class Register extends AuthAbstract
{
    public $mailData;

    public function __invoke()
    {
        return $this->tpl->render('@auth/register');
    }

    #[Route(methods: 'post', pipe: [
        RegisterValidation::class, 
        RegisterTokenMiddleware::class, 
        ControllerAttributeMiddleware::class])]
    #[MailByData]
    public function check()
    {
        $path = APPPATH . 'auth/messages/data/';
        $userdata = $this->request->getParsedBody();
        $data = require $path . 'register_confirm.php';
        $this->mailData = require $path . 'register_confirm_mail.php';

        return $this->tpl->render('@auth/message', $data);
    }

    public function confirm($code)
    {
        if ($code === $this->session->get('code')) {
            $userdata = $this->session->pull('userdata');
            $userdata['password'] = password_hash($userdata['password'], PASSWORD_DEFAULT);
            User::fromArray($userdata)->save();
            $status = true;
        } else {
            $status = false;
        }

        $data = require APPPATH . 'auth/messages/data/register_complete.php';

        $this->session->delete('code');
        $this->session->regenerate(true);
        
        return $this->tpl->render('@auth/message', $data);
    }
}
