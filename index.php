<?php

require 'services/Router.php';
require 'services/SiswaServices.php';

$router = new Router();

$router->get('/', function(){
    echo 'Home Page';
});

$router->get('/siswa', SiswaServices::class . '::execute');
$router->post('/siswa', SiswaServices::class . '::postSiswa');
$router->post('/siswa/update', SiswaServices::class . '::updateSiswa');

// $router->post('/contact', function($params){
//     var_dump($params);
// });

$router->addNotFoundHandler(function(){
    $title = "Not Found";
    require_once 'views/404.phtml';
});

$router->run();