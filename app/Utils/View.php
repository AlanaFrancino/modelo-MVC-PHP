<?php

namespace App\Utils;

class View{

    /**
     * Variaveis padrão da view
     *
     * @var array
     */
    private static $vars = [];

    /**
     * Metodo responsavel por definir os dados iniciais da classe
     *
     * @param array $vars
     */
    public static function init($vars = [])
    {
       self::$vars = $vars;
    }
    
    /**
     * Metodo responsavel por retornar o conteudo de uma view
     *
     * @param string $view
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ .'/../../resources/view/'.$view.'.html';

        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     *  Metodo responsavel por retornar o conteudo renderizado de uma view
     *
     * @param string $view
     * @param array $vars (string/numeric)
     * @return void
     */
    public static function render($view, $vars = [])
    {
       $contentView = self::getContentView($view);

       $vars = array_merge(self::$vars, $vars);

       //Chaves do array de variaveis 
        $keys = array_keys($vars);

        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        //Retorna o conteudo renderizado 
       return str_replace($keys,array_values($vars),$contentView);
    }

}