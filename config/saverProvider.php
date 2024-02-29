<?php

use App\Entity\Burime;
use App\Entity\Genre;
use App\Model\ModelBurime;
use App\Model\ModelGenres;
use Modules\Auth\Model\ModelUser;
use Modules\Auth\User;

return [
    // User::class => ModelUser::class,
    Burime::class => ModelBurime::class,
    Genre::class => ModelGenres::class,
];
