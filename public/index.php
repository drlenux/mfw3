<?php

require_once __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/web.php';
(new \core\WebApp())->run($config);
