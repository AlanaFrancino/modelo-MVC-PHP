<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

class Testemony{

    /**
     * id do depoimento
     *
     * @var integer
     */
    public $id;

    /**
     * Nome de quem fez o depoimento
     *
     * @var string
     */
    public $nome;

    /**
     * mensagem 
     *
     * @var string
     */
    public $mensagem;

    /**
     * data do depoimento
     *
     * @var string
     */
    public $data;

    /**
     * Cadastra depoimento
     *
     * @return boolean
     */
    public function Cadastrar()
    {
        $this->data = date('Y-m-d H:i:s');

        $this->id = (new Database('depoimento'))->insert([
            'nome'      => $this->nome,
            'mensagem'  => $this->mensagem,
            'data'      => $this->data,
        ]);

        return true;
    }

    /**
     * Undocumented function
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('depoimento'))->select($where,$order,$limit,$fields);
    }

}