<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\CarRepostsController;
use app\controllers\HomeController;
use app\controllers\CarsController;
use app\core\Application;

$app = new Application();

$app->router->get('/', [HomeController::class, 'index']);

$app->router->get('/cars', [CarsController::class, 'index']);
$app->router->post('/cars', [CarsController::class, 'store']);
$app->router->post('/cars/import', [CarsController::class, 'import']);

$app->router->get('/car/report/by/brand', [CarRepostsController::class, 'brand']);

$app->run();