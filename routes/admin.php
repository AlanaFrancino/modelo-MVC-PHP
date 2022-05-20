<?php
use \App\Http\Response;
use \App\Controller\Admin;


//salva rotas
$router->get('/admin',[
    'middlewares' => [
        'requered-admin-login'
    ],
    function(){
        return new Response(200,'Admin = )');
    }
]);


$router->get('/admin/login',[
    'middlewares' => [
        'requered-admin-logout'
    ],
    function($request){
        return new Response(200, Admin\Login::getLogin($request));
    }
]);


$router->post('/admin/login',[
    'middlewares' => [
        'requered-admin-logout'
    ],
    function($request){
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

$router->get('/admin/logout',[
    'middlewares' => [
        'requered-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Login::setLogout($request));
    }
]);