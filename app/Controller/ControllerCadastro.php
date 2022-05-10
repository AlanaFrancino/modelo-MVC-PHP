<?php
namespace App\Controller;

use Src\Classes\ClassRender;
use Src\Interfaces\InterfaceView;
use App\Model\ClassCadastro;

class ControllerCadastro extends ClassCadastro{

    protected $Id;
    protected $Nome;
    protected $Sexo;
    protected $Cidade;

    use \Src\Traits\TraitUrlParser;

    public function __construct()
    {
        if(count($this->parseUrl())==1)
        {
            $Render=new ClassRender();
            $Render->setTitle("Cadastro");
            $Render->setDescription("Faça seu cadastro.");
            $Render->setKeywords("cadastro de clientes, cadastro");
            $Render->setDir("cadastro");
            $Render->renderLayout();
        }
    }

    #Receber variáveis
    private function recVariaveis()
    {
        if(isset($_POST['Id']))
        { 
            $this->Id=$_POST['Id']; 
        }
        if(isset($_POST['Nome']))
        { 
            $this->Nome=filter_input(INPUT_POST, 'Nome', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_POST['Sexo']))
        { 
            $this->Sexo=filter_input(INPUT_POST, 'Sexo', FILTER_SANITIZE_SPECIAL_CHARS); 
        }
        if(isset($_POST['Cidade']))
        { 
            $this->Cidade=filter_input(INPUT_POST, 'Cidade', FILTER_SANITIZE_SPECIAL_CHARS); 
        }
    }

    #Chamar o método de cadastro da ClassCadastro
    public function cadastrar()
    {
        $this->recVariaveis();
        $this->cadastroClientes($this->Nome, $this->Sexo,$this->Cidade);
        echo "Cadastro efetuado com sucesso!";
    }

    public function seleciona()
    {
        $this->recVariaveis();
        $B=$this->selecionaClientes($this->Nome, $this->Sexo,$this->Cidade);

        echo "
        <form name='FormDeletar' id='FormDeletar' action ='".DIRPAGE."cadastro/deletar' method='post'>
            <table >
                <tr>
                    <td>Ação</td>
                    <td>Nome</td>
                    <td>Sexo</td>
                    <td>Cidade</td>
                </tr>
                ";
                foreach($B as $C){
                echo "
                <tr>
                    <td><input type='checkbox' id='Id' name='Id[]' value='$C[Id]'> <img class='ImageEdit' rel='$C[Id]'src='' alt='Editar' ></td>
                    <td>$C[Nome]</td>
                    <td>$C[Sexo]</td>
                    <td>$C[Cidade]</td>
                </tr>
                ";
                }
                echo "
            </table>
            <input type='submit' value='Deletar'>
        </form>
        ";
    }

    public function deletar()
    {
        $this->recVariaveis();
        foreach($this->Id as $IdDeletar)
        {
            $this->deletarClientes($IdDeletar);
        }
    }
    public function puxaDB($Id)
    {
        $this->recVariaveis();
        $B=$this->selecionaClientes($this->Nome, $this->Sexo,$this->Cidade);

        foreach($B as $C){
            if($C['Id'] == $Id){
                $Nome=$C['Nome'];
                $Sexo=$C['Sexo'];
                $Cidade=$C['Cidade'];
            }
        }
        echo "
        <form name='FormAtualizar' id='FormAtualizar' action='".DIRPAGE."cadastro/atualizar' method='post'>
            <input type='hidden' name='Id' id='Id' value='$Id'><br>
            Nome: <input type='text' name='Nome' id='Nome' value='$Nome'><br>
            Sexo:
            <select name='Sexo' id='Sexo'>
                <option value='$Sexo'>$Sexo</option>
                <option value='Masculino'>Masculino</option>
                <option value='Feminino'>Feminino</option>
            </select><br>
            Cidade: <input type='text' name='Cidade' id='Cidade' value='$Cidade'><br>
            <input type='submit' value='Atualizar'>
        </form>

        ";
    }

    #Atualizar dados dos clientes
    public function atualizar()
    {
        $this->recVariaveis();
        $this->atualizarClientes($this->Id, $this->Nome,$this->Sexo,$this->Cidade);
        echo "Usuário Atualizado com Sucesso!";
    }
}