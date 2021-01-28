<?php

namespace core\auth\session;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Session
{
    public function isAuth(): bool;
    public function getId(): ?int;
    public function getRules(): array;
    public function isAllowRule(string $rule): bool;
    public function login(ResponseInterface $response, int $id, array $rules, int $exp): ResponseInterface;
    public function logout(ResponseInterface $response): ResponseInterface;
    public function auth(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}
