<?php
class Materia{
    private $id_usuario;
    private $nome_materia;
    private $acertos;
    private $erros;
    private $id_materia;
    private $id_simulado;

    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr,$value){
        $this->$attr = $value;
        return $this;
    }
}
