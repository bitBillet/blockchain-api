<?php

namespace App\Middleware;


use App\Enum\Blockchain\Method;
use Slim\Http\Request;
use Slim\Http\Response;

class CheckBlockchainMethod
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $method = Method::tryFrom((string)$request->getParam('method'));

       return match (true) {
            $method === Method::CONVERT && $request->isPost() => $next($request, $response),
            $method === Method::RATES && $request->isGet()    => $next($request, $response),
            default                                           => throw new \Exception('Неверный метод')
        };
    }
}
