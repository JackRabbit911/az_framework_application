<?php

return [
    'connect' => [
        'mysql' => [
            'host' => enva('DB_HOST'),
            'database' => enva('DB_DATABASE'),
            'username' => enva('DB_USERNAME'),
            'password' => enva('DB_PASSWORD'),
            'charset' => enva('DB_CHARSET'),
        ],
    ],
];
