<?php


namespace src\controllers;


use core\auth\Auth;
use core\RestApi\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\models\User;

class UserController extends Controller
{
    public function post(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $res = [];
        try {
            $model = new User($request);
            $status = $model->register($this->container->get(Auth::class));
            $res['status'] = $status;
        } catch (\Exception $e) {
            $res['status'] = false;
            $res['error'] = $e->getMessage();
        }
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($res));
        return $response;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!$this->needAuth()) {
            $response = $response->withStatus(401);
            return $response;
        }
        /** @var Auth $auth */
        $auth = $this->container->get(Auth::class);
        $response = $response->withHeader('Content-Type', 'application/json');
        $res = [];
        $res['id'] = $auth->getSession()->getId();
        $response->getBody()->write(json_encode($res));
        return $response;
    }
}