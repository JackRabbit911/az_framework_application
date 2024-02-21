<?php

namespace App\Jobs;

use Sys\Mailer\Mailer;
use Sys\Mailer\Mail;

class SendMail
{
    public function __invoke(Mailer $mailer, $data)
    {
        $mail = Mail::fromJson($data);
        return $mailer->send($mail);
    }
}
