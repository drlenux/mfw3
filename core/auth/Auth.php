<?php

namespace core\auth;

use core\auth\session\Session;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;

class Auth
{
    public function __construct(
        private ContainerInterface $container,
        private Session $session
    )
    {
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function login(string $login, string $password): bool
    {
        /** @var Medoo $medoo */
        $medoo = $this->container->get(Medoo::class);
        $data = $medoo->get('users', ['id', 'password'], ['login' => $login]);
        if (is_array($data) && count($data)) {
            $this->getSession()->login($data['id'], [], time() + 60);
            return true;
        }
        return false;
    }

    public function register(string $login, string $password): bool
    {
        /** @var Medoo $medoo */
        $medoo = $this->container->get(Medoo::class);
        $has = $medoo->has('users', ['login' => $login]);
        if ($has) return false;
        $id = $medoo->count('users');
        $medoo->insert('users', [
            'id' => $id + 1,
            'login' => $login,
            'password' => md5($password),
            'token' => null,
        ]);
        return true;
    }

    public function auth(string $token): bool
    {
        return false;
    }
}