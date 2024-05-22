<?php
class ObservacaoService{
    private $observacao;
    private $conexao;
    public function __construct( Observacao $observacao,Conexao $conexao){
        $this->observacao = $observacao;
        $this->conexao = $conexao->conectar();
    }
    public function inserir(){
        $query = 'insert into tb_observacao(observacao,tb_user_materia) values(?,?)';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $this->observacao->observacao);
        $smtm->bindValue(2, $this->observacao->tb_user_materia);
        return $smtm->execute();
    }
    public function read(){
        $query = 'SELECT observacao from tb_observacao where tb_user_materia = ?';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $this->observacao->tb_user_materia);
        $smtm->execute();
        return $smtm->fetchAll(PDO::FETCH_OBJ);
    }
    public function remover(){
        $query = 'DELETE from tb_observacao where tb_user_materia = ? and observacao = ?';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $this->observacao->tb_user_materia);
        $smtm->bindValue(2, $this->observacao->observacao);
        return $smtm->execute();
    }
}