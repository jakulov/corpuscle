<?php

return ['service' => [
    'request' => [
        'class' => \Symfony\Component\HttpFoundation\Request::class
    ],
    'router' => [
        'class' => \jakulov\Corpuscle\Router\ApiRouter::class,
        'aware' => [
            'setConfig' => ':router'
        ]
    ],
    'logger' => [
        'class' => \jakulov\Corpuscle\Log\Logger::class,
        'aware' => [
            'setLogStorage' => '@file_log_storage',
            'setConfig' => ':log',
            'setRequest' => '@request',
        ],
    ],
    'logger.event_listener' => [
        'class' => \jakulov\Corpuscle\Log\EventListener::class,
    ],
    'log_storage' => '@file_log_storage',
    'file_log_storage' => [
        'class' => \jakulov\Corpuscle\Log\FileLogStorage::class,
        'args' => [':log.dir', ':log.file'],
    ],
    'event_dispatcher' => [
        'class' => \jakulov\Event\EventDispatcher::class,
        'aware' => [
            'setConfig' => ':event',
        ],
    ],
]];