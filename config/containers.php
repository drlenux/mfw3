<?php

return [
    'latte' => function () {
        $latte = new \Latte\Engine();
        $latte->setTempDirectory(__DIR__ . '/../tmp/latte/');
        return $latte;
    },
    'twig' => function () {
        return \Slim\Views\Twig::create(__DIR__ . '/../src/views', ['cache' => __DIR__ . '/../tmp/twig']);
    },
    \core\template\View::class => function (\Psr\Container\ContainerInterface $container) {
        return new \core\template\latte\View($container->get('latte'));
    },
    \Medoo\Medoo::class => function ()
    {
        if (!is_dir(__DIR__ . '/../tmp/db')) {
            mkdir(__DIR__ . '/../tmp/db');
        }
        return new Medoo\Medoo([
            'database_type' => 'sqlite',
            'database_file' => __DIR__ . '/../tmp/db/tmp.db',
        ]);
    },
    \core\auth\Auth::class => function (\Psr\Container\ContainerInterface $container) {
        return new \core\auth\Auth($container, new \core\auth\session\PhpSession());
    },
];