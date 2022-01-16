<?php

class ClassePessoa{
    private $pdo;
    public function __construct($dbname, $host, $user, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
        } catch (Exception $e) {
            echo "Erro relacionado com a base de dados: ".$e->getMessage();
        }   
        catch (Exception $e) {
            echo "Erro genérico: ".$e->getMessage();
            exit;
        }       
    }

    /*obter os dados no banco de dados e exibir na tela */
    public function buscarDados(){
        $res= array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarPessoa($nome, $telefone,$email){
        
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email=:e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0)
        {
            return false;
        }else {
            $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES(:n, :t, :e)");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        return true;
        }


        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }


    public function excluirPessoa($id){
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id=:id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE id=:id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function actualizarDados($id){
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id=:id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}