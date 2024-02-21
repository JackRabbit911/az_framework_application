<?php

namespace App\Http\Controller;

use App\Model\ModelHome;
use Sys\Controller\WebController;
use Az\Route\Route;

final class Home extends WebController 
{
    // #[Route(ajax: true)]
    // #[Route(methods: ['post', 'put'])]
    public function __invoke(ModelHome $model)
    {
        // 1/0;
        $data = [
            'h1' => 'Welcome!',
            'isdb' => $model->dbExits(),
        ];

        return $this->render('home', $data);
    }
}
