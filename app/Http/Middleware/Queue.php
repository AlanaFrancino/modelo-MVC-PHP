<?php
namespace App\Http\Middleware;

class Queue{

    /**
     * Mapeamento de middleware
     *
     * @var array
     */
    private static $map = [];


    /**
     * Mapeamento de middlewares que serão carregadas em todas as rotas
     *
     * @var array
     */
    private static $default = [];

    /**
     * Fila de middleware a sererem executad,os 
     *
     * @var array
     */
    private $middleware = [];

    /**
     * Fução de execução do controlador 
     *
     * @var Closure
     */
    private $controller;

    /**
     * Argumenots da função do controlador 
     *
     * @var array
     */
    private $controllerArgs = [];


    /**
     * Metodo responsavel por contruir a classe de fila de middlewares
     *
     * @param array $middleware
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middleware,$controller,$controllerArgs)
    {
        $this->middleware       = array_merge(self::$default,$middleware);
        $this->controller       = $controller;
        $this->controllerArgs   = $controllerArgs;
    }

    /**
     * Metodo reponsavel por definir o mapeamento de middlewares
     *
     * @param array $map
     * @return void
     */
    public static function setMap($map)
    {
        self::$map = $map;
    }

    /**
     * Metodo reponsavel por definir o mapeamento de middlewares padrão
     *
     * @param array $default
     * @return void
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    /**
     * Metodo responsavel por execultar o proximo nivel da fila de middlewares
     *
     * @param Request $request
     * @return Response
     */
    public function next($request)
    {
        if(empty($this->middleware)) 
        return call_user_func_array($this->controller, $this->controllerArgs);

        $middleware = array_shift($this->middleware);

        if(!isset(self::$map[$middleware])){
            throw new \Exception("Problemas ao processar o middleware da requisição", 500);
        }

        $queue = $this;
        $next = function($request) use($queue){
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request,$next);

    }

    
}