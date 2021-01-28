<?php


namespace src\controllers;


use core\auth\Auth;
use core\RestApi\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\models\User;

class AuthController extends Controller
{
    public function post(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $user = new User($request);
        $user->login($this->container->get(Auth::class));
        return $response;
    }
}