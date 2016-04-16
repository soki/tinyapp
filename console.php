<?php

$app = require __DIR__.'/bootstrap.php';

use Symfony\Component\Console\Application;

$application = new Application();
//$application->add(new JobCommand());
$application->run();
