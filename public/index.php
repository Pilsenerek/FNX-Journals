<?php

declare(strict_types=1);

use App\Application;

$loader = require '../vendor/autoload.php';

$application = new Application();

echo $application->run();
