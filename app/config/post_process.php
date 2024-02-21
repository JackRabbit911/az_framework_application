<?php

use Sys\Model\CommitListener;
use Sys\Profiler\Profiler;

$array = [
    [CommitListener::class, 'handle'],
];

if (IS_DEBUG) {
    array_push($array, Profiler::class);
}

return $array;
