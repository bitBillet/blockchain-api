<?php

use App\Enum\Response\ResponseCode;
use App\Helper\ResponseHelper;
use Slim\Http\Request;
use Slim\Http\Response;

return [
    'settings' => [
        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    ],
    'errorHandler' => function () {
        return function (Request $request, Response $response, Exception $exception) {
            return $response->withStatus(ResponseCode::ERROR->value)
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Content-Type', 'application/json')
                ->withJson(
                    ResponseHelper::getErrorData($exception->getMessage()),
                    ResponseCode::ERROR->value
                );
        };
    },
];
