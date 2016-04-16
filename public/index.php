<?php
define('ROOT_PATH', realpath('../'));

$app = require ROOT_PATH . '/bootstrap.php';

$request = $app->make('request');
$request->dispatch('App\Http\Controllers', function($router){
    require ROOT_PATH . '/app/Http/routes.php';
});
