<?php

class UsuarioService{
    private $conexao;
    private $usuario;
    public function __construct(Conexao $conexao, Usuario $usuario){
        $this->conexao = $conexao->conectar();
        $this->usuario = $usuario;
    }
    public function inserir(){
        $query = 'insert into tb_usuario(nome,email,senha) values(?,?,?)';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1,$this->usuario->nome);
        $smtm->bindValue(2,$this->usuario->email);
        $smtm->bindValue(3,$this->usuario->senha);
        return $smtm->execute();
    }
    //essa função serve para verificar se o usuário consta na base de dados 
    public function verificar(){
        $query = 'select nome, email, senha,id_usuario ';
        $query .= 'from tb_usuario ';
        $query .= 'where nome=? and email=? and senha=?';
        $smtm=$this->conexao->prepare($query);
        $smtm->bindValue(1,$this->usuario->nome);
        $smtm->bindValue(2,$this->usuario->email);
        $smtm->bindValue(3,$this->usuario->senha);
        $smtm->execute();
        $verificar = $smtm->fetch(PDO::FETCH_OBJ);
        return $verificar;
    }
    public function atualizar(){
        
    }
    public function deletar(){
        
    }
}