<?php

use core\RouteItem;

return [
    'isProd' => false,
    'displayErrorDetails' => true,
    'logErrors' => false,
    'logErrorDetails' => false,
    'tracy' => \Tracy\Debugger::PRODUCTION,
    'containers' => require __DIR__ . '/containers.php',
    'routing' => [
        '/' => new RouteItem(\src\controllers\HomeController::class, 'index'),
        '/page/{id:[0-9]+}' => new RouteItem(\src\controllers\ArticlesController::class),
        '/user' => new RouteItem(\src\controllers\UserController::class),
        '/login' => new RouteItem(\src\controllers\AuthController::class),
    ]
];