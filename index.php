<?php
require __DIR__.'/includes/app.php';
use App\Http\Router;

//Inicia Route
$router = new Router(URL);
include __DIR__.'/routes/pages.php';
include __DIR__.'/routes/admin.php';

//imprime response da rota
$router->run()->sedResponse();