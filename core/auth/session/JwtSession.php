<?php


namespace core\auth\session;


use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JwtSession implements Session
{
    private string $token = '';
    private array $payload = [];

    public function __construct(
        private string $publicKey,
        private string $privateKey
    )
    {
    }

    public function login(ResponseInterface $response, int $id, array $rules, int $exp): ResponseInterface
    {
        foreach ($rules as &$rule) $rule = sha1($rule);
        unset($rule);

        $payload = [
            'iss' => $_SERVER['HTTP_HOST'],
            'aud' => $_SERVER['HTTP_HOST'],
            'iat' => time(),
            'exp' => $exp,
            'data' => [
                'id' => $id,
                'rules' => $rules,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'key' => sha1(implode(';', $_SERVER['HTTP_USER_AGENT'])),
            ]
        ];

        $jwt = JWT::encode($payload, $this->privateKey, 'RS256');
        return $response->withHeader('auth' , $jwt);
    }

    public function auth(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $auth = $request->getHeader('auth');
        if (!is_array($auth) || !count($auth)) {
            return $response;
        }
        $this->token = $auth[0];
        if (!$this->isAuth()) {
            return $response;
        }
        return $response->withHeader('auth', $this->token);
    }

    public function isAuth(): bool
    {
        try {
            $decode = (array) JWT::decode($this->token, $this->publicKey, ['RS256']);
            $key = sha1(implode(';', $_SERVER['HTTP_USER_AGENT']));
            $this->payload = $decode['data'];
            return
                $decode['exp'] > time() &&
                $decode['data']['ip'] === $_SERVER['REMOTE_ADDR'] &&
                $decode['data']['key'] === $key;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getId(): ?int
    {
        $this->payload['id'];
    }

    public function getRules(): array
    {
        return $this->payload['rules'];
    }

    public function isAllowRule(string $rule): bool
    {
        return in_array(sha1($rule), $this->payload['rules']);
    }

    public function logout(ResponseInterface $response): ResponseInterface
    {
        return $response;
    }
}