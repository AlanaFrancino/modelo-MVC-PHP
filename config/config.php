<?php
#Arquivos diretórios raízes
$PastaInterna="GitHub/modelo-MVC-PHP/";
define('DIRPAGE',"http://{$_SERVER['HTTP_HOST']}/{$PastaInterna}"); //caminho absoluto da pagina

if(substr($_SERVER['DOCUMENT_ROOT'],-1)=='/'){ //verifica se o servidor coloca a barra final na url
    define('DIRREQ',"{$_SERVER['DOCUMENT_ROOT']}{$PastaInterna}"); //caminho absoluto de requisição
} else{ 
    define('DIRREQ',"{$_SERVER['DOCUMENT_ROOT']}/{$PastaInterna}"); 
}

#Diretórios Específicos
define('DIRIMG',DIRPAGE."public/img/");
define('DIRCSS',DIRPAGE."public/css/");
define('DIRJS',DIRPAGE."public/js/");
define('DIRBOOTS',DIRPAGE."public/bootstrap/");

#Acesso ao banco de dados
define('HOST',"localhost");
define('DB',"cosmetic_ecomerc");
define('USER',"root");
define('PASS',"");