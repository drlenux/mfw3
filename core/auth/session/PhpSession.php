<?php

namespace core\auth\session;

use JetBrains\PhpStorm\Pure;

class PhpSession implements Session
{
    public function __construct()
    {
        @session_start();
    }

    public function isAuth(): bool
    {
        return isset($_SESSION['id']);
    }

    public function getId(): ?int
    {
        return $_SESSION['id'] ?? null;
    }

    public function getRules(): array
    {
        return $_SESSION['rules'] ?? [];
    }

    #[Pure]
    public function isAllowRule(string $rule): bool
    {
        return in_array($rule, $this->getRules());
    }

    public function isActive(): bool
    {
        return $_SESSION['exp'] ?? 0 > time();
    }

    public function login(int $id, array $rules, int $exp): void
    {
        $_SESSION['id'] = $id;
        $_SESSION['rules'] = $rules;
        $_SESSION['exp'] = $exp;
    }

    public function logout(): void
    {
        session_destroy();
    }
}