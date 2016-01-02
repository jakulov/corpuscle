<?php

return ['container' => [
    'di' => [
        'aware' => [
            \Psr\Log\LoggerAwareInterface::class => [
                'setLogger' => '@service.logger',
            ],
        ],
    ],
]];