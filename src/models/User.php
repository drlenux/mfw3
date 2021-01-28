<?php


namespace src\models;


use core\auth\Auth;
use core\Validate;
use core\ValidateMap;
use core\ValidateTrait;
use Psr\Http\Message\ServerRequestInterface;

class User
{
    use ValidateTrait;

    private array $data = [];

    public function __construct(
        private ServerRequestInterface $request
    )
    {
        $this->data = $this->request->getParsedBody() ?? [];
        $this->validate($this->data);
    }

    public function rules(): ValidateMap
    {
        return (new ValidateMap())
            ->setRule(Validate::name('login')->required()->string(6))
            ->setRule(Validate::name('password')->required()->string(6));
    }

    public function register(Auth $auth): bool
    {
        return $auth->register($this->data['login'], $this->data['password']);
    }

    public function login(Auth $auth)
    {
        return $auth->login($this->data['login'], $this->data['password']);
    }
}