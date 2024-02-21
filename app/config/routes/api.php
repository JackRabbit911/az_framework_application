<?php

use App\Http\Controller\Api;

$this->route->controller('api/{action?}/{param?}', Api::class);
