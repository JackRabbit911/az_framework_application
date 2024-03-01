<?php

namespace Auth\Middleware;

use Az\Validation\Middleware\ValidationMiddleware;

final class PasswordConfirmValidation extends ValidationMiddleware
{
    protected function setRules()
    {
        $this->validation->rule('password', 'required|password')
                        ->rule('confirm', 'required|confirm(:data)');
    }

    protected function modifyData(&$data)
    {
        unset($data['confirm']);
    }
}
