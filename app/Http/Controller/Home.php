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
        // $route = $this->request->getAttribute(Route::class);
        // $pipeline = $route->getPipeline();
        // dd($pipeline);
        // dd($this->user);
        return $this->render('home');
    }
}
