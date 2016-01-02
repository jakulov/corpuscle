<?php

return ['event' => [
    'app.shutdown' => [
        '@logger.event_listener' => ['onShutdown', -1],
    ],
]];