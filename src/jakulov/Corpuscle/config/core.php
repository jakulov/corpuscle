<?php

return [
    'router' => [
        '/' => \jakulov\Corpuscle\Controller\DefaultController::class,
        'error' => \jakulov\Corpuscle\Controller\DefaultController::class
    ],
    'service' => [
        'router' => [
            'class' => \jakulov\Corpuscle\Router\ApiRouter::class,
            'aware' => [
                'setConfig' => ':router'
            ]
        ],
    ],
];