<?php

namespace App\Http;

class Response{

    /**
     * Codigo de status HTTP
     *
     * @var integer
     */
    private $httpCode = 200;

    /**
     * Cabeçalho response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Tipo do conteudo que esta sendo retornado 
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteudo do response 
     *
     * @var mixed
     */
    private $content;

    
    /**
     * Metodo responsavel por iniciar a classe e definir os valores
     *
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode     = $httpCode;
        $this->content      = $content;
        $this->setContentType($contentType);
    }

    /**
     * Metodo responsavel por alterar o content tyoe do response 
     *
     * @param string $contentType
     * @return void
    */
    public function setContentType($contentType)
    {
        $this->contentType  = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Metodo reponsavel por adicionar um registro no cabeçalho de response
     *
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * metodo responsavel por enviar headers para o navegador
     *
     */
    public function sendHeaders()
    {
        //Status
        http_response_code($this->httpCode);
        //Envia Headers
        foreach($this->headers as $key=>$value){
            header($key.':'.$value);
        }
    }


    /**
     * Metodo reponsavel por imprimir a resposta para o usuario
     *
     */
    public function sedResponse()
    {
        //Envia os headers
        $this->sendHeaders();

        //Imprime o conteudo
        switch($this->contentType){
            case 'text/html';
            echo $this->content;
            exit;

        }
    }
}