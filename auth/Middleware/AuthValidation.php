<?php

namespace Auth\Middleware;

use Auth\Model\ModelUser;
use Az\Validation\Validation;
use Az\Validation\Middleware\ValidationMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use HttpSoft\Response\RedirectResponse;

final class AuthValidation extends ValidationMiddleware
{
    private ModelUser $model;

    public function __construct(Validation $validation, ModelUser $model)
    {
        parent::__construct($validation);
        $this->model = $model;
    }

    protected function setRules()
    {
        $this->validation->rule('email', 'required|email')
            ->rule('password', 'required|password')
            ->rule('password', [$this->model, 'isPairEmailPswd'], ':email')
            ->rule('remember', 'boolean')
            ->addMsgPath(APPPATH . 'modules/Auth/messages');
    }

    protected function errorHandler(ServerRequestInterface $request, array $data): ResponseInterface
    {
        $validationResponse = $this->validation->getResponse();

        if ($validationResponse['password']['status'] === 'error' 
            && $validationResponse['password']['key'] === 'isPairEmailPswd') {
                $validationResponse['email'] = [
                    'status' => 'error',
                    'value' => '',
                    'msg' => '',
                ];
        }

        $session = $request->getAttribute('session');
        $session->flash('validation', $validationResponse);
        return new RedirectResponse($request->getServerParams()['HTTP_REFERER'], 302);
    }
}
