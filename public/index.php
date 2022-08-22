<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\HomeController;
use app\core\Application;

$app = new Application();

$app->router->get('/', [HomeController::class, 'index']);
$app->router->post('/contact', [HomeController::class, 'contactPost']);

$app->run();