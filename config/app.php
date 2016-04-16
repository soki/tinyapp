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

    'mysql_main' => [
        'dsn' => 'mysql:host=127.0.0.1;port=3306',
        'dbname' => 'test',
        'user' => 'root',
        'password' => '',
        'charset' => 'UTF8',
    ],

    'queue' => [
        'host' => '127.0.0.1',
        'port' => '11300',
    ],
];
