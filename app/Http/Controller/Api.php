<?php

namespace App\Http\Controller;

use Sys\Controller\BaseController;
use Sys\Exception\MimeNegotiator;
use Az\Route\Route;
use Sys\Middleware\ApiMiddleware;

final class Api extends BaseController
{
    #[Route(methods: ['post', 'put'])]
    public function __invoke()
    {
        // 1/0;
        $accept_header = $this->request->getHeaderLine('Accept');
        $mimeNegotiator = new MimeNegotiator($accept_header);
        $responseType = $mimeNegotiator->getResponseType();

        return ['mode' => getMode(), 'type' => $responseType, 'accept' => $accept_header];
    }
}
