<?php

namespace core\template;

use Psr\Http\Message\ResponseInterface;

abstract class View
{
    public function __construct(protected $view)
    {
    }

    abstract public function render(ResponseInterface $response, ...$data): ResponseInterface;
}