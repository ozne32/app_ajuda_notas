<?php
class MateriaService{
    private $simulado;
    private $materia;
    private $conexao;
    //básico só para pegar fazer a conexão que eu quero e passar a matéria para ela
    public function __construct(Materia $materia, Conexao $conexao){
        $this->materia = $materia;
        $this->conexao = $conexao->conectar();
    }
    public function inserir(){
        //primeira query para pegar a o id_materia
        $query = 'SELECT * from tb_materias where nome_materia = ?';
        $smtm= $this->conexao->prepare($query);
        $smtm->bindValue(1, $this->materia->__get('nome_materia'));
        $smtm->execute();
        $listas = $smtm->fetch(PDO::FETCH_OBJ);
        $id_materia = $listas->id_materia; 
        //segunda query para inserir os elementos em tb_user_materia
        $query='insert into tb_user_materia(acertos,erros,id_usuario,id_materia,id_simulado) ';
        $query .='values(?,?,?,?,?)'    ;
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $this->materia->__get('acertos'));
        $smtm->bindValue(2, $this->materia->__get('erros'));
        $smtm->bindValue(3, $this->materia->__get('id_usuario'));
        $smtm->bindValue(4, $id_materia);
        $smtm->bindValue(5, $this->materia->__get('id_simulado'));
        return $smtm->execute();
    }
    public function verificar($simulado){
        $query = 'SELECT 
        id_materia
        from tb_materias 
        where nome_materia = ?';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(1, $this->materia->__get('nome_materia'));
        $stmt->execute();
        $listas = $stmt->fetch(PDO::FETCH_OBJ);
        $id_materia = $listas->id_materia;
        $query = 'SELECT 
        id_materia, id_simulado, id_usuario
        from tb_user_materia 
        where id_materia = ? and id_simulado = ? and id_usuario = ?';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $id_materia);
        $smtm->bindValue(2, $this->materia->__get('id_simulado'));
        $smtm->bindValue(3, $this->materia->__get('id_usuario'));
        // $smtm->bindValue(1, $this->materia->__get('id_usuario'));
        $smtm->execute();
        $listas = $smtm->fetchAll(PDO::FETCH_OBJ);
        return empty($listas);
    }
}
