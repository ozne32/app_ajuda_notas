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
    public function pegar_id_acertos_erros(){
        $query = 'SELECT id_materia,id_simulado, acertos,erros from tb_user_materia where id_usuario = ? and id_materia = ?';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $this->materia->__get('id_usuario'));
        $smtm->bindValue(2, $this->materia->__get('id_materia'));
        $smtm->execute();
        $listas = $smtm->fetchAll(PDO::FETCH_OBJ);
        return $listas;
    }

    //aqui é usado para pegar os nomes de matérias e simulados
    public function pegar_nomes($ids){
        $nomes = [];
        $query = 'SELECT nome_simulado from tb_simulados where id_simulado = ?';
        $smtm = $this->conexao->prepare($query);
        $smtm->bindValue(1, $ids->id_simulado);
        $smtm->execute();
        $nome_simulado = $smtm->fetch(PDO::FETCH_OBJ);
        $query = 'SELECT nome_materia from tb_materias where id_materia = ?';
        $smtm= $this->conexao->prepare($query);
        $smtm->bindValue(1, $ids->id_materia);
        $smtm->execute();
        $nome_materia = $smtm->fetch(PDO::FETCH_OBJ);
        $nomes['simulado'] = $nome_simulado->nome_simulado;
        $nomes['materia'] = $nome_materia->nome_materia;
        $nomes['acertos']=$ids->acertos;
        $nomes['erros']=$ids->erros;
        return $nomes;
    }
    public function pegar_ids($acao){
        //id simulado 
        if($acao ==1){
            $query = 'SELECT id_simulado from tb_simulados where nome_simulado = ?';
            $smtm = $this->conexao->prepare($query);
            $smtm->bindValue(1, $_GET['simulado']);
            $smtm->execute();
            $id_simulado = $smtm->fetch(PDO::FETCH_OBJ)->id_simulado;
            //id materias
            $query = 'SELECT id_materia from tb_materias where nome_materia = ?';
            $smtm = $this->conexao->prepare($query);
            $smtm->bindValue(1, $_GET['materia']);
            $smtm->execute();
            $id_materia = $smtm->fetch(PDO::FETCH_OBJ)->id_materia;
            echo $id_simulado;
            echo $id_materia;
            //pegar o id_user_materias
            $query = 'SELECT id_user_materia from tb_user_materia where id_simulado = ? and id_materia = ? and id_usuario = ?';
            $smtm = $this->conexao->prepare($query);
            $smtm->bindValue(1, $id_simulado);
            $smtm->bindValue(2, $id_materia);
            $smtm->bindValue(3, $_GET['id']);
            $smtm->execute();
            $id_user_materia = $smtm->fetch(PDO::FETCH_OBJ)->id_user_materia;
            return $id_user_materia;            
        }else if($acao ==2){
            $query = 'SELECT id_materia from tb_materias where nome_materia = ?';
            $smtm = $this->conexao->prepare($query);
            $smtm->bindValue(1, $_GET['materia']);
            $smtm->execute();
            $id_materia = $smtm->fetch(PDO::FETCH_OBJ)-> id_materia;
            return $id_materia;
        }
    }
    public function editar($acerto_erro){
        if($acerto_erro == 'acertos'){
            $query = 'UPDATE tb_user_materia set acertos = ?  where id_usuario = ? and id_simulado = ? and id_materia = ?';
            $smtm = $this->conexao->prepare($query);
            $smtm->bindValue(1, $this->materia->acertos);
            $smtm->bindValue(2, $this->materia->id_usuario);
            $smtm->bindValue(3, $this->materia->id_simulado);
            $smtm->bindValue(4, $this->materia->id_materia);
            return $smtm->execute();
        }else if($acerto_erro == 'erros'){
            $query = 'UPDATE tb_user_materia set erros = ?  where id_usuario = ? and id_simulado = ? and id_materia = ?';
            $smtm = $this->conexao->prepare($query);
            $smtm->bindValue(1, $this->materia->__get('erros'));
            $smtm->bindValue(2, $this->materia->__get('id_usuario'));
            $smtm->bindValue(3, $this->materia->__get('id_simulado'));
            $smtm->bindValue(4, $this->materia->__get('id_materia'));
            return $smtm->execute();
        }
    }
}
