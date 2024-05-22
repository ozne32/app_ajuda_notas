<?php
class Observacao{
    private $observacao;
    private $id_observacao;
    private $tb_user_materia;

    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr, $value){
        $this->$attr = $value;
        return $this;
    }
}