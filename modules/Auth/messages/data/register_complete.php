<?php

$success = [
    'status' => 'success',
    'title'=> 'Congratulations!',
    'appeal' => 'Congratulations!',
    'msg'  => 'You have successfully registered!<br><a href="'
            . path('auth') . '">Welcome to Sign In!</a>',
];

$danger = [
    'status' => 'danger',
    'title'=> 'Whoops!',
    'appeal' => 'Sorry',
    'msg' => 'Confirmation code does not match or the link is out of date.<br>Please repeat the 
                <a href="' . path('register') .'">registration</a> procedure',
];

return ($status) ? $success : $danger;
