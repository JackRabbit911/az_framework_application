<?php

namespace App\Http\Controller;

use Az\Route\Route;
use Sys\Controller\WebController;

final class Home extends WebController 
{
    // #[Route(ajax: true)]
    // #[Route(methods: ['post', 'put'])]
    public function __invoke()
    {
        // dd($this->user);
        return $this->render('layout');
        // return $this->render('home');
    }
}
