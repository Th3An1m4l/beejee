<?php

use Bramus\Router\Router;
use Josantonius\Session\Session;

Session::init();

$router = new Router();

$router->setNamespace('App\Controllers');

$router->get('/', 'BaseController@index');
$router->post('/saveTaskForm', 'BaseController@saveTaskForm');
$router->post('/updateTaskList', 'BaseController@updateTaskList');
$router->post('/dropDb', 'BaseController@dropDb');
$router->post('/loginAttempt', 'AdminController@loginAttempt');
$router->post('/logoutAttempt', 'AdminController@logoutAttempt');
$router->get('/init', 'BaseController@dropDb');

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "404";
});

$router->run();