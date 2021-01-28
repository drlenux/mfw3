<?php

namespace core;

class RouteItem
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    /**
     * RouteItem constructor.
     * @param string $class
     * @param string|null $action
     * @param string $method
     * @throws \Exception
     */
    public function __construct(
        private string $class,
        private ?string $action = null,
        private string $method = self::METHOD_GET
    )
    {
        if (!in_array($this->method, [
            self::METHOD_GET,
            self::METHOD_POST,
            self::METHOD_PUT,
            self::METHOD_PATCH,
            self::METHOD_DELETE
        ])) {
            throw new \Exception('bad method in router');
        }
    }

    public function get(): array
    {
        return [
            $this->class,
            $this->action,
            $this->method,
        ];
    }
}