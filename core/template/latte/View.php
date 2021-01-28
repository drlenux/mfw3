<?php

namespace core\template\latte;

use Latte\Engine;
use Psr\Http\Message\ResponseInterface;

/**
 * Class View
 * @package core\template\latte
 * @property Engine $view
 */
class View extends \core\template\View
{
    /**
     * @param ResponseInterface $response
     * @param mixed ...$data
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, ...$data): ResponseInterface
    {
        $body = $this->view->renderToString(...$data);
        $response->getBody()->write($body);
        return $response;
    }
}
