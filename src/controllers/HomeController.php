<?php


namespace src\controllers;


use core\template\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{

    public function index(ServerRequestInterface $request, ResponseInterface $response, View $view): ResponseInterface
    {
        $file = __DIR__ . '/../views/home/index.latte';
        $params = [
            'items' => ['hello', 'world']
        ];

        return $view->render($response, $file, $params);
    }
}