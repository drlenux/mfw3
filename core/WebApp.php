<?php

namespace core;

use core\RestApi\RestController;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use src\controllers\HomeController;
use Tracy\Debugger;

/**
 * Class WebApp
 * @package core
 */
class WebApp
{
    private ContainerInterface $container;
    public function run(array $config)
    {
        Debugger::enable($config['tracy']);
        $container = new Container();
        $this->container = $container;
        $app = Bridge::create($container);
        $app->addErrorMiddleware(
            $config['displayErrorDetails'],
            $config['logErrors'],
            $config['logErrorDetails']
        );

        $app->addRoutingMiddleware();

        $this
            ->initContainer($config)
            ->initMiddleware($app, $config);

        if ($config['isProd'] ?? false) {
            $routeCollector = $app->getRouteCollector();
            $routeCollector->setCacheFile(__DIR__ . '/../tmp/router.cache.php');
        }
        $app->run();
    }

    private function initContainer(array $config): static
    {
        foreach ($config['containers'] ?? [] as $name => $f) {
            $this->container->set($name, $f);
        }
        return $this;
    }

    private function initMiddleware(App $app, array $config): static
    {
        foreach ($config['routing'] as $url => $conf) {
            if (!is_array($conf)) {
                if (is_object($conf) && $conf instanceof RouteItem) {
                    $conf = $conf->get();
                } else {
                    continue;
                }
            }

            $class = $conf[0];
            $action = $conf[1] ?? null;
            $method = $conf[2] ?? RouteItem::METHOD_GET;
            $container = $this->container;

            $container->set($class, function () use ($class, $container) { return new $class($container); });

            if ($this->isRest($class)) {
                $app->group($url, function (RouteCollectorProxy $group) use ($class) {
                    foreach (['GET', 'DELETE', 'PATCH', 'PUT', 'POST'] as $method) {
                        $group->{$method}('', [$class, $method]);
                    }
                });
            } else {
                $app->{$method}($url, [$class, $action]);
            }
        }
        return $this;
    }

    private function isRest(string $className): bool
    {
        $class = new $className($this->container);
        $status = $class instanceof RestController;
        unset($class);
        return $status;
    }
}