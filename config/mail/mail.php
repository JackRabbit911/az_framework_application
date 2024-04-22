<?php

return [
    'is_smtp' => env('MAIL_IS_SMTP'),
    'smtp' => env('MAIL_SMTP'),
    'smtp_port' => env('MAIL_SMTP_PORT'),
    'smtp_auth' => env('MAIL_SMTP_AUTH'),
    'password' => env('MAIL_PASSWORD'),
    'from_address' => env('MAIL_FROM_ADDRESS'),
    'from_name' => env('MAIL_FROM_NAME'),
];
