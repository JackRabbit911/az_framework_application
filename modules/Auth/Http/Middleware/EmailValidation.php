<?php

namespace Modules\Auth\Http\Middleware;

use Modules\Auth\Model\ModelUser;
use Az\Validation\Validation;
use Az\Validation\Middleware\ValidationMiddleware;

final class EmailValidation extends ValidationMiddleware
{
    private ModelUser $model;

    public function __construct(Validation $validation, ModelUser $model)
    {
        parent::__construct($validation);
        $this->model = $model;
    }

    protected function setRules()
    {
        $path = APPPATH . 'modules/Auth/messages';

        $this->validation
            ->rule('email', 'required|email')
            ->rule('email', [$this->model, 'isRegisteredEmail'])
            ->addMsgPath($path);
    }
}
