<?php

namespace App\Controller;

use App\Enum\Response\ResponseCode;
use App\Helper\ResponseHelper;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class AbstractController
{
    protected Request $request;

    protected Response $response;
    protected array $routeParams = [];

    public function __construct(Request $request, Response $response, array $routeParams = [])
    {
        $this->request     = $request;
        $this->response    = $response;
        $this->routeParams = $routeParams;
    }

    public function successResponse(array $data): Response
    {
        return $this->response->withJson(
            ResponseHelper::getSuccessData($data),
            ResponseCode::SUCCESS->value
        );
    }
}
