<?php
require __DIR__ . '/../vendor/autoload.php';

//$userRepo = new \App\Repository\UserRepository(\App\Service\Database\Connector::getInstance());
//echo '<pre>';
//print_r($userRepo->getByLogin('someuser'));
//echo '</pre>';
//die();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header(
        'Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization'
    );
    header(
        'Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE'
    );
    header('HTTP/1.1 200 OK');
    die('denied');
}

require __DIR__ . '/../vendor/autoload.php';

ini_set('error_reporting', 'E_ALL & ~E_DEPRECATED');

$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);
$app->run();

