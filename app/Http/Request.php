<?php

namespace App\Http;

class Request{

    /**
     * Instacia do Router
     *
     * @var Router
     */
    private $router;

    /**
     * Metodo HTTP da requisição
     *
     * @var string
     */
    private $httpMethod;

    /**
     * URI da pagina
     *
     * @var string
     */
    private $uri;

    /**
     * Parametros da URL ($_GET)
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Variaveis recebidas no POST da pagina ($_POST)
     *
     * @var array
     */
    private  $postVars = [];

    /**
     * Cabeçalho da requisição 
     *
     * @var array
     */
    private $headers = [];

    public function __construct($router)
    {
        $this->router       = $router;
        $this->queryParams  = $_GET ?? [];
        $this->postVars     = $_POST ?? [];
        $this->headers      = getallheaders();
        $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    /**
     * Metodo responsavel por definir a URI
     *
     */
    private function setUri()
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        $xUri = explode('?',$this->uri);

        $this->uri = $xUri[0];
    }

    /**
     * Metodo responsavel em retonar a instacia de router
     *
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * responsavel por retornar o metodo HTTP da requisição
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * responsavel por retornar o URI da requisição
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * responsavel por retornar os headers da requisição
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    /**
     * responsavel por retornar os parametros da URL da requisição
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * responsavel por retornar as variaveis POST da requisição
     *
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

}