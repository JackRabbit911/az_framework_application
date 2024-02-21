<?php

use Sys\Console\Controller as ConsoleController;

$this->route->controller('/~console/{model}/{method}', ConsoleController::class)
    ->tokens(['model' => '[\w\/]+'])
    ->methods('post')
    ->filter(function ($route) {
        $params = $route->getParameters();
        $model = str_replace('/', '\\', $params['model']);

        if (method_exists($model, $params['method'])) {
            return true;
        }

        return false;
    });
