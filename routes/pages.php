<?php
use \App\Http\Response;
use \App\Controller\Pages;


//salva rotas
$router->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

$router->get('/pagina/{id}/',[
    function($id){
        return new Response(200,'Pagina' .$id);
    }
]);

$router->get('/depoimentos',[
    function($request){
        return new Response(200,Pages\Testimony::getTestimonies($request));
    }
]);

$router->post('/depoimentos',[
    function($request){
        return new Response(200,Pages\Testimony::InsereTestimonies($request));
    }
]);
