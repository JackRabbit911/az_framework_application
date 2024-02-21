<?php

namespace App\Listener;

use App\Facade\Mail as FacadeMail;
use Attribute;
use Sys\Observer\Interface\Observer;

#[Attribute]
class Mail2User implements Observer
{
    private ?string $template;
    private $object;

    public function __construct(?string $template = null)
    {
        $this->template = $template ?? 'mail/templates/message';
    }

    public function update(object|string $object): void
    {
        $this->object = (is_object($object)) ? $object : container()->get($object);
    }

    public function handle()
    {
        $user = $this->object->user;
        $data = $this->object->mailData;

        if ($user) {
            $mail = FacadeMail::create($this->template)
            ->to($user->email, $user->name);

            if (isset($data['subject'])) {
                $mail->subject($data['subject']);
            }

            if (isset($data['text'])) {
                $mail->altBody($data['text']);
            }

            $mail->data($data['data'])->enqueue();
        }
    }
}
