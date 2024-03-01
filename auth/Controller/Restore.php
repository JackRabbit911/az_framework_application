<?php

namespace Auth\Controller;

use Auth\User;
use App\Listener\MailByData;
use Az\Route\Route;
use Modules\Auth\Http\Middleware\EmailValidation;
use Modules\Auth\Http\Middleware\PasswordConfirmValidation;
use Psr\Http\Server\RequestHandlerInterface;
use Sys\Middleware\ControllerAttributeMiddleware;

final class Restore extends AuthAbstract
{
    public array $mailData;
    private string $path;

    public function __construct()
    {
        parent::__construct();
        $this->path = APPPATH . 'modules/Auth/messages/data/';
    }

    public function __invoke()
    {
        return $this->tpl->render('@auth/email');
    }

    #[Route(methods: 'post', pipe: [
        EmailValidation::class, 
        ControllerAttributeMiddleware::class])]
    #[MailByData]
    public function email()
    {
        $user = $this->model->getUser();
        
        $this->session->uid = $user->id;
        $this->session->code = bin2hex(random_bytes(16));

        $data = require $this->path . 'restore_password.php';
        $this->mailData = require $this->path . 'restore_password_email.php';
        $this->mailData['email'] = $user->email;
        $this->mailData['name'] = $user->name;

        return $this->tpl->render('@auth/message', $data);
    }

    public function confirm($code)
    {
        if ($code === $this->session->get('code')) {
            return $this->redirect(path('restore', ['action' => 'password']));  
        }

        $data = require $this->path . 'restore_whoops.php';

        return $this->render('@auth/message', $data);
    }

    public function password(RequestHandlerInterface $handler)
    {
        if ($this->session->uid) {
            return $this->render('@auth/password');
        }

        return $handler->handle($this->request);
    }

    #[Route(methods: 'post', pipe: PasswordConfirmValidation::class)]
    public function check(User $user)
    {
        $user = $this->model->find($this->session->uid);
        $user->password = password_hash($this->request->getParsedBody()['password'], PASSWORD_DEFAULT);
        $user->save();
        $this->session->destroy();
        $data = require $this->path . 'restore_success.php';

        return $this->render('@auth/message', $data);
    } 
}
