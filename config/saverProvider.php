<?php

use App\Entity\Burime;
use App\Entity\Genre;
use App\Model\ModelBurime;
use App\Model\ModelGenres;
use Auth\Model\ModelUser;
use Auth\User;

return [
    // User::class => ModelUser::class,
    Burime::class => ModelBurime::class,
    Genre::class => ModelGenres::class,
];
