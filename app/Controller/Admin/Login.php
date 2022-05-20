<?php

namespace App\Controller\Admin;

use App\Model\Entity\User;
use App\Utils\View;
use App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page{

    /**
     * Metodo responsavel por retornar a rederização da pagina de login
     *
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request,$errorMessage = null)
    {
        $status = !is_null($errorMessage) ? View::render('admin/login/status',[
            'mensagem' => $errorMessage
        ]) : '';

        $content = View::render('admin/login',[
            'status' => $status
        ]);

        return parent::getPage('Login teste', $content);

    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public static function setLogin($request)
    {
        $postVars = $request->getPostVars();

        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $user = User::getUserByEmail($email);

        if(!$user instanceof User){
            return self::getLogin($request,'Email invalido');
        }
        if(!password_verify($senha,$user->senha)){
            return self::getLogin($request,'Senha Invalida');
        }

        SessionAdminLogin::login($user);
        
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Metodo responsavel por deslogar o usuario
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout($request)
    {
        SessionAdminLogin::logout();
        
        $request->getRouter()->redirect('/admin/login');
    }



}