<?php

use Modules\Guide\GuideController;

$this->route->controller('/~guide/{part?}/{file?}', GuideController::class, 'guide')
    ->tokens([
        'part' => 'docs|tutorial|examples|',
        'file' => '[\w\.\-\/]*'
    ])
    ->methods('get');
