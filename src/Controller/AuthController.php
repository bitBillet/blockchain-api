<?php

namespace App\Controller;

use App\Entity\Token;
use App\Repository\UserRepository;
use App\Service\Database\Connector;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends AbstractController
{
    private UserRepository $userRepository;
    public function __construct(Request $request, Response $response, array $routeParams = [])
    {
        $this->userRepository = new UserRepository(Connector::getInstance());
        parent::__construct($request, $response, $routeParams);
    }

    /**
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function auth(): Response
    {
        $login    = (string)$this->request->getParam('login');
        $password = (string)$this->request->getParam('password');
        $user     = $this->userRepository->getByLogin($login);

        if (true === password_verify($password, $user->getPassword())) {
            $user->setToken(new Token());
            $this->userRepository->updateToken($user);
            $result = $this->successResponse(
                [
                    'auth_token' => $user->getToken()
                ]
            );
        } else {
            throw new \Exception('Неверный пароль');
        }

        return $result;
    }
}
