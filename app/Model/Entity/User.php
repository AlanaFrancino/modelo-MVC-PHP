<?php

namespace App\Model\Entity;
use \WilliamCosta\DatabaseManager\Database;

class User{

    /**
     * id do usuario
     *
     * @var integer
     */
    public $id;

    /**
     * Nome do usuario
     *
     * @var string
     */
    public $nome;

    /**
     * email 
     *
     * @var string
     */
    public $email;

    /**
     * senha
     *
     * @var string
     */
    public $senha;

    /**
     * Cadastra depoimento
     *
     * @return boolean
     */
    public function Cadastrar()
    {
        $this->data = date('Y-m-d H:i:s');

        $this->id = (new Database('depoimento'))->insert([
            'nome'   => $this->nome,
            'email'  => $this->email,
            'senha'  => password_hash($this->senha, PASSWORD_DEFAULT),
        ]);

        return true;
    }

    /**
     * Metodo responsavel por retonrar um usuario com base em seu email 
     *
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {   
        return (new Database(('usuarios')))->select('email = "'.$email.'"')->fetchObject(self::class);

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