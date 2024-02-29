<?php

return [
    'app' => [
        'controller' => "/Http/Controller/{FILENAME}.php",
        'model' => "/Model/Model{FILENAME}.php",
        'entity' => "/Entity/{FILENAME}",
        'middleware' => "/Http/Middleware/{FILENAME}Middleware.php",
        'validation' => "/Http/Middleware/{FILENAME}Validation.php",
        'job' => "/Jobs/{FILENAME}.php",
        'listener' => "/Listener/{FILENAME}.php",
        'facade' => "/Facade/{FILENAME}.php",
        'command' => "/Console/{FILENAME}.php",
        'view' => "/views/{filename}.twig",
        'api' => [
            'controller' => "/Http/Controller/Api/{FILENAME}.php",
            'model' => "/Model/Api/Model{FILENAME}.php",
            'middleware' => "/Http/Middleware/Api/{FILENAME}Middleware.php",
        ]
    ],
    'submodule' => [
        'controller' => "/{FILENAME}Controller.php",
        'model' => "/Model{FILENAME}.php",
        'entity' => "/{FILENAME}",
        'middleware' => "/{FILENAME}Middleware.php",
        'validation' => "/{FILENAME}Validation.php",
        'job' => "/{FILENAME}Job.php",
        'listener' => "/{FILENAME}Listener.php",
        'facade' => "/Facade{FILENAME}.php",
        'command' => "/Console/{FILENAME}.php",
        'view' => "/views/{filename}.twig",
    ]
];
