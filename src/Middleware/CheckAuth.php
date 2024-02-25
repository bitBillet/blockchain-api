<?php

declare(strict_types=1);

namespace App\Middleware;


use App\Repository\UserRepository;
use App\Service\Database\Connector;
use Doctrine\DBAL\Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class CheckAuth
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(Connector::getInstance());
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response|void
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $authResult = false;
        $authData   = $request->getHeader('Authorization');

        if (count($authData) > 0) {
            $authString = $authData[array_key_first($authData)];

            if (str_contains($authString, 'Bearer')) {
                $authToken = explode(' ', $authString)[1];
                $authResult = $this->userRepository->existByToken($authToken);
            }
        }

        if (true === $authResult) {
            $response = $next($request, $response);
        } else {
            throw new \Exception('Ошибка авторизации');
        }

        return $response;
    }
}