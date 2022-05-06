<?php
header("Content-Type: text/html; charset=utf-8;");
require_once("../src/vendor/autoload.php");
require_once("../config/config.php");

use Src\Classes\ClassRoutes;

$new = new ClassRoutes();

$teste= $new->getRota();

var_dump($teste);