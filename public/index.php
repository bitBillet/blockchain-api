<?php

require __DIR__ . '/../vendor/autoload.php';

ini_set('error_reporting', 'E_ALL & ~E_DEPRECATED');

$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);
$app->run();
