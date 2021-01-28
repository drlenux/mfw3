<?php

namespace src\controllers;

use core\auth\Auth;
use core\RestApi\Controller;
use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ArticlesController
 * @package src\controllers
 */
class ArticlesController extends Controller
{
    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(json_encode(['status' => true]));
        return $response;
    }
}