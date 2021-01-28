<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();
$container = new \DI\Container();
$config = require __DIR__ . '/config/console.php';

foreach ($config['containers'] ?? [] as $name => $f) {
    $container->set($name, $f);
}

foreach ($config['commands'] ?? [] as $className) {
    $class = new $className;
    if ($class instanceof \core\Console) {
        $class->setContainer($container);
    }
    $app->add($class);
}

$app->run();