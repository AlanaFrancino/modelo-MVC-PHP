<?php
namespace App\Controller;

use App\Model\ClassLogin;
use \Src\Classes\ClassRender;

class ControllerLogin extends ClassLogin{

    use \Src\Traits\TraitUrlParser;

    public function __construct()
    {
        if(count($this->parseUrl())==1){
            $Render=new ClassRender();
            $Render->setTitle('Login');
            $Render->setDescription('Faça seu login');
            $Render->setKeywords('login, login website, area restrita');
            $Render->setDir('login');
            $Render->renderLayout();
        }
    }

    #Validar o login do usuário
    public function validarLogin()
    {
        $Validacao=$this->validarUsuario($_POST['Usuario'],$_POST['Senha']);
        if($Validacao==true){
            echo "Login efetuado";
        }else{
            echo "Não foi feito o login";
        }
    }
}