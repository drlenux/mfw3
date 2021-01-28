<?php

namespace core\template\twig;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * Class View
 * @package core\template\twig
 * @property Twig $view
 */
class View extends \core\template\View
{
    /**
     * @param ResponseInterface $response
     * @param mixed ...$data
     * @return ResponseInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(ResponseInterface $response, ...$data): ResponseInterface
    {
        return $this->view->render($response, ...$data);
    }
}