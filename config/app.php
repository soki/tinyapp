<?php

return [
    'debug' => true,

    'logdir' => './',

    'session' => [
        'save_handler' => 'files',
        'maxlifetime' => 300,
        'name' => 'stgame-sid',
        'save_path' => '/tmp',
    ],

    'mysql' => [
        'main' => [
            'dsn' => 'mysql:host=127.0.0.1;port=3306',
            'dbname' => 'test',
            'user' => 'root',
            'password' => '',
            'charset' => 'UTF8',
        ],
    ],

    'redis' => [
        'hash' => [
            ['host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5, 'rate' => 0], //float 秒
            ['host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5, 'rate' => 64],
        ],
        'cache' => ['host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5],
    ],
];
