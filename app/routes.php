<?php

declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\BlockchainController;
use App\Middleware\CheckAuth;
use App\Middleware\CheckBlockchainMethod;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $app->post('/api/v1/auth', function (Request $request, Response $response, array $args) {
        return (new AuthController($request, $response, $args))->auth();
    });

    $app->get('/api/v1', function (Request $request, Response $response, array $args) {
        return (new BlockchainController($request, $response, $args))->rates();
    })->add(new CheckAuth())
        ->add(new CheckBlockchainMethod());

    $app->post('/api/v1', function (Request $request, Response $response, array $args) {
        return (new BlockchainController($request, $response, $args))->convert();
    })->add(new CheckAuth())
        ->add(new CheckBlockchainMethod());
};
