<?php

namespace Auth;

use Sys\Entity\Entity;
use Auth\Model\ModelUser;
use DateTime;
use Sys\Trait\FromArray;

#[ModelUser]
final class User extends Entity
{
    use FromArray;

    const FEMALE = 0;
    const MALE = 1;

    public function age(string $date = 'today')
    {
        return (new DateTime($this->dob))->diff(new DateTime($date))->y;
    }
}
