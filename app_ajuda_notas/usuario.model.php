<?php
class Usuario{
    private $nome;
    private $senha;
    private $email;
    private $id_usuario;
    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr,$value){
        $this->$attr=$value;
        return $this;
    }
}