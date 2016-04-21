<?php

$app = require __DIR__.'/bootstrap.php';

use Symfony\Component\Console\Application;
use App\Command\TestCommand;

$application = new Application();
$application->add(new TestCommand());
$application->run();
