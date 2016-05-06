<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__ . '/config.php';
require __DIR__ . '/route.php';

return $app;
