<?php

return [

    'channels' => [
        'syslog' => [
            'driver' => 'syslog',
            'path' => 'logs/syslog/laravel.log',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => LOG_USER,
            'replace_placeholders' => true,
        ],
    ],

];
