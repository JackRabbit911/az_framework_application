<?php

namespace Auth\Controller;

use Auth\Model\ModelUser;
use Sys\Controller\FormController;
use DI\Attribute\Inject;

abstract class AuthAbstract extends FormController
{
    #[Inject]
    protected ModelUser $model;

    protected $view = '@auth/message_email';

    protected string $tplPath = APPPATH . 'auth/views';

    protected function setReferer(bool $force = false)
    {
        $ref = $this->session->ref;

        if (!$force && $ref) {
            return ($ref == url()) ? url('home') : $ref;
        }

        $ref = $this->request->getServerParams()['HTTP_REFERER'] ?? url('home');
        $this->session->ref = $ref;

        return $ref;
    }

    protected function getReferer()
    {
        $home = url('home');
        $default = $this->request->getServerParams()['HTTP_REFERER'] ?? $home;     
        $ref = $this->session->pull('ref', $default);

        return ($ref == url()) ? $home : $ref;
    }

    protected function _before()
    {
        $this->tpl->getEngine()
            ->getLoader()
            ->addPath(realpath($this->tplPath), 'auth');
    }
}
