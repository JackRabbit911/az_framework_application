<?php

return [
    'cookie' => [
        'lifetime' => 600,
    ],
    'options' => [
        'save_path'     => WRITABLE . 'sessions',
        // 'gc_maxlifetime' => 100,
    ],
    'guard_agent' => false,
];