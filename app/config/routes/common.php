<?php

use Sys\Exception\ErrorController;
use Sys\Controller\Media;
use Modules\Image\ImageController;

$this->route->get('/error/{code}', ErrorController::class);
$this->route->get('/media/{lifetime}/{file}', [Media::class, 'process'], 'media')
    ->tokens(['lifetime' => '\d*', 'file' => '.*']);
$this->route->get('/image/{func?}/{size?}/{file?}', ImageController::class, 'image')
    ->tokens([
        'func' => 'thumb|crop|height|width|foreign|',
        'size' => '\d{2,4}x?\d{0,4}',
        'file' => '[\w\_\-\/]+\.{1}(jpg|jpeg|png|gif){1}',
    ]);
