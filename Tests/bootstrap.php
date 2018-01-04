<?php

$file = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

$autoload = require_once $file;

require_once __DIR__ . '/app/Controller/FakeController.php';
require_once __DIR__ . '/app/AppKernel.php';
