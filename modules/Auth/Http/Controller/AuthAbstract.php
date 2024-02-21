<?php

namespace Modules\Auth\Http\Controller;

use Modules\Auth\Model\ModelUser;
use Sys\Controller\WebController;
use DI\Attribute\Inject;

abstract class AuthAbstract extends WebController
{
    #[Inject]
    protected ModelUser $model;

    protected $view = '@auth/message_email';

    protected string $tplPath = APPPATH . 'modules/Auth/views';

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
        $pos = strpos($this->request->getServerParams()['REQUEST_URI'], '/auth');

        return ($ref == url() || $pos === 0) ? $home : $ref;
    }

    protected function _before()
    {
        $this->tpl->getEngine()
            ->getLoader()
            ->addPath(realpath($this->tplPath), 'auth');
    }
}
