<?php
// Functionality of this index.php is the entry of system, 
// it gets the request and gives back the response.
// Since it can be accessed via browser, 
// it should be put into the folder /public;
require_once __DIR__.'/../vendor/autoload.php';

use app\Router;
use app\controllers\ProductController;

$router = new Router();

$router->get('/',[ProductController::class, 'index']); // This sentence means whenever the url is '/', 
                                                       // the function 'index' will be executed.
                                                       // According to the use of namespace, we know this
                                                       // class located in the directory of app\controllers\
$router->get('/products',[ProductController::class, 'index']);
$router->get('/products/create',[ProductController::class, 'create']);
$router->post('/products/create',[ProductController::class, 'create']);
$router->get('/products/update',[ProductController::class, 'update']);
$router->post('/products/update',[ProductController::class, 'update']);
$router->post('/products/delete',[ProductController::class, 'delete']);

$router->resolve(); // resovle will detect what the current router is and execute the corresponding function