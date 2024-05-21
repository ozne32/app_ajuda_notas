<?php

class Conexao{
    private $user = 'root';
    private $host = 'localhost';
    private $dbname = 'ajuda_nota';
    private $senha = '';

    public function conectar(){
        try{
            $conexao = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                "$this->user",
                "$this->senha"
            );
            return $conexao;
        }catch(PDOException $e){
            echo 'Erro'. $e->getCode().'<br>Mensagem:'. $e->getMessage();
        }
    }

}