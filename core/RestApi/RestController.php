<?php

namespace core\RestApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RestController
{
    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
    public function post(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
    public function put(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
    public function patch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}