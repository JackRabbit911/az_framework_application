<?php

namespace App\Jobs;

use Az\Session\SessionInterface;

final class SessGC
{
    public function __invoke(SessionInterface $session)
    {
        $count = $session->gc();
        $session->destroy();
        unset($session);
        return $count;    
    }
}
