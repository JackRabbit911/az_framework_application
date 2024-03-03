<?php

namespace App\Facade;

use Auth\User;
use Sys\Cron\Cron;
use Sys\Cron\Entity\Queue;
use Sys\Mailer\Mail as MailerMail;
use Sys\Mailer\Mailer;

final class Mail
{
    private MailerMail $mail;
    private Mailer $mailer;
    
    public static function create(?string $file = null)
    {
        $instance = container()->get(__CLASS__);
        $instance->mail = new MailerMail();

        if ($file) {
            $instance->mail->setDraft($file);
        }

        return $instance;
    }

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function to(...$recipient)
    {
        if ($recipient[0] instanceof User) {
            $address = $recipient[0]->email;
            $name = $recipient[0]->name;
        } else {
            $address = $recipient[0];
            $name = $recipient[1] ?? '';
        }

        $this->mail->to($address, $name);
        return $this;
    }

    public function mail()
    {
        return $this->mail;
    }

    public function send()
    {
        return $this->mailer->send($this->mail);
    }

    public function enqueue(string $created = null)
    {
        if (!$this->isCron()) {
            return $this->send();
        }
        
        $data = [
            'name' => 'sendmail',
            'data' => $this->mail->toJson(),
        ];

        $queue = new Queue($data);

        if ($created) {
            $queue->created = $created;
        }

        return $queue->save();
    }

    public function __call($name, $arguments)
    {
        call_user_func_array([$this->mail, $name], $arguments);
        return $this;
    }

    private function isCron()
    {
        $status_file = config('cron', 'status_file') ?? Cron::STATUSFILE;

        if (!is_file($status_file)) {
            return false;
        }
        
        return (file_get_contents($status_file)) ? true : false;
    }
}
