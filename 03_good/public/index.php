<?php
// Functionality of this index.php is to take in the request and give out the response;
require_once __DIR__.'/../vendor/autoload.php';

use app\Router;
use app\controllers\ProductController;

$router = new Router();

$router->get('/',[ProductController::class, 'index']); // This sentence means whenever the url is '/', 
                                                       // the function 'index' will be executed.
$router->get('/products',[ProductController::class, 'index']);
$router->get('/products/create',[ProductController::class, 'create']);
$router->post('/products/create',[ProductController::class, 'create']);
$router->get('/products/update',[ProductController::class, 'update']);
$router->post('/products/update',[ProductController::class, 'update']);
$router->post('/products/delete',[ProductController::class, 'delete']);

$router->resolve(); // resovle will detect what the current router is and execute the corresponding function