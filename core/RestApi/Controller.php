<?php

namespace core\RestApi;

use core\auth\Auth;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Controller
 * @package core\RestApi
 */
abstract class Controller implements RestController
{
    public function __construct(protected ContainerInterface $container)
    {
        $this->init();
    }

    public function init(): void
    {
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(405, 'Method not Allowed');
    }

    public function post(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(405, 'Method not Allowed');
    }

    public function put(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(405, 'Method not Allowed');
    }

    public function patch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(405, 'Method not Allowed');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(405, 'Method not Allowed');
    }

    protected function needAuth(): bool
    {
        /** @var Auth $auth */
        $auth = $this->container->get(Auth::class);
        return $auth->getSession()->isAuth();
    }
}