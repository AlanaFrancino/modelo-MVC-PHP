<?php

namespace App\Session\Admin;

class Login{

    /**
     * Metodo resposavel por iniciar a sessão
     *
     */
    private static function init()
    {
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }
    /**
     * Metodo responsavel por criar o login do usuario
     *
     * @param User $user
     * @return void
     */
    public static function login($user)
    {
        self::init();

        $_SESSION['admin']['user'] = [
            'id'    => $user->id,
            'nome'  => $user->nome,
            'email' => $user->email,
    
        ];
        return true;
    }

    /**
     * Retorna se o usuario esta logado
     *
     * @return boolean
     */
    public static function isLogged()
    {
        self::init();
        return isset($_SESSION['admin']['user']['id']);
    }

    /**
     * Metodo Responsavel por excutar o logout do usuario
     *
     * @return boolean
     */
    public static function Logout()
    {
        self::init();

        unset($_SESSION['admin']['user']);
    }
}