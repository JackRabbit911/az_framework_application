<?php

namespace App\Http\Controller;

use Sys\Controller\WebController;

final class Home extends WebController 
{
    // #[Route(ajax: true)]
    // #[Route(methods: ['post', 'put'])]
    public function __invoke()
    {
        return $this->render('home');
    }
}
