<?php

require __DIR__ .'/../vendor/autoload.php';
use App\Utils\View;
use App\Http\Middleware\Queue as MiddlewareQueue;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;

Environment::load(__DIR__.'/../');

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

define('URL',getenv('URL'));

//Define valor padrão das variaveis que estarão em todas as rotas
View::init([
    'URL' => URL
]);

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenance::class,
    'requered-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class,
    'requered-admin-login' => \App\Http\Middleware\RequireAdminLogin::class,
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);