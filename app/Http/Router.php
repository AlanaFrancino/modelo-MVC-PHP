<?php

namespace App\Http;

use App\Http\Middleware\Queue as MiddlewareQueue;
use \Closure;
use \Exception;
use \ReflectionFunction;

class Router{
    
    /**
     * URL completa do projeto
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Indice das rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instacia de Request
     *
     * @var Request
     */
    private $request;


    /**
     * Metodo responsavel por iniciar a classe
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request  = new Request($this);
        $this->url      = $url;
        $this->setPrefix();
        
    }

    /**
     * Metodo responsavel por definir o profixo das rotas 
     *
     * @return void
     */
    public function setPrefix()
    {
        //Informações da Url
        $parseUrl = parse_url($this->url);
        // Define o prefixo
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Metodo reponsavel por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRouter($method, $route, $params = [])
    {
        //validação dos parametros 
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }
        
        $params['middlewares'] = $params['middlewares'] ?? [];


        $params['variables'] = [];

        $patternVariable = '/{(.*?)}/';
        
        if(preg_match_all($patternVariable,$route,$matches)){
           
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }
       
        //padrão de validação URL
        $patternRoute = '/^'.str_replace('/','\/',$route).'$/';
        //Add a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;

    }

    /**
     * Metodo responsavel por definir uma rota de GET
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function get($route, $params = [])
    {
        return $this->addRouter('GET',$route,$params);
    }

    /**
     * Metodo responsavel por definir uma rota de POST
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post($route, $params = [])
    {
        return $this->addRouter('POST',$route,$params);
    }

    /**
     * Metodo responsavel por definir uma rota de PUT
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put($route, $params = [])
    {
        return $this->addRouter('PUT',$route,$params);
    }

    /**
     * Metodo responsavel por definir uma rota de DELETE
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete($route, $params = [])
    {
        return $this->addRouter('DELETE',$route,$params);
    }


    /**
     * Metodo responsavel por retonrar a uri desconsiderando o prefixo
     *
     * @return string
     */
    public function getUri()
    {
        $uri = $this->request->getUri();

        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];

        return end($xUri);
    }


    /**
     * Metodo responsavel por retornar os dados atual
     *
     * @return array
     */
    public function getRoute()
    {
       $uri = $this->getUri();

       $httpMethod = $this->request->getHttpMethod();
       foreach ($this->routes as $patternRoute=>$method)
        {
            if(preg_match($patternRoute,$uri,$matches)){

                if(isset($method[$httpMethod]));{
                    unset($matches[0]);

                    $keys = $method[$httpMethod]['variables'];
                    $method[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $method[$httpMethod]['variables']['request'] = $this->request;

                    return $method[$httpMethod];
                }
                throw new Exception("Metodo não permitido", 405);
            }
            
            
        }
        throw new Exception("Url não encontrada", 404);   
        
    }


    /**
     * Metodo responsavel por executar a rota atual
     *
     * @return Response
     */
    public function run()
    {
        try{
            $route = $this->getRoute();
            if(!isset($route['controller'])){
                throw new Exception("Url não pode ser processada", 500);
            }

            $args = [];

            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '' ;
            }

            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);
        }
        catch(Exception $e){
            return new Response($e->getCode(),$e->getMessage());
        }
    }

    /**
     * metodo responsavel por retornar a URL atual
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url.$this->getUri();
    }

    /**
     * Metodo responsavel por redirecionar a url
     *
     * @param string $route
     */
    public function redirect($route)
    {
        $url = $this->url.$route;
        
        header('location: '.$url);
        exit;
    }



}