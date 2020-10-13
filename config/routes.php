<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],
    'register' => [
        'controller' => 'main',
        'action' => 'register',
    ],
    'logout' => [
        'controller' => 'main',
        'action' => 'logout',
    ],

    'phones\??.*' => [			// С передачей GET запросов
        'controller' => 'phones',
        'action' => 'index',
    ]
];
