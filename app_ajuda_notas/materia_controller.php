<?php
require '../app_ajuda_notas/conexao.php';
require '../app_ajuda_notas/materia.model.php';
require '../app_ajuda_notas/materia.service.php';
require '../app_ajuda_notas/observacao.model.php';
require '../app_ajuda_notas/observacao.service.php';
session_start();
$id = $_SESSION['id'];
$acao = isset($_GET['acao'])?$_GET['acao']:$acao;
// fazer a página de colocar notas, onde o usuário vai ir colocando as suas notas, e a cada atualizada ele vai 
// mudando qual matéria ele está falando 
// tem que melhorar isso: 
print_r($_POST);
if($acao =='adicionar'){
    if($_POST['simulado'] !=0 && $_POST['acertos'] !=null && $_POST['erros'] !=null){
        $lista_materias = ['Física','Matematica','Interpretação textual','Química','Geografia','História', 'Sociologia','Literatura','Inglês','Filosofia','Biologia'];
        $chave = array_search($_GET['materia'], $lista_materias);
        //começo processo para inserir a materia na tabela
        $conexao = new Conexao;
        $materia = new Materia;
        $materia->__set('id_usuario',$_GET['id'])->
        __set('nome_materia',$_GET['materia'])->
        __set('acertos',$_POST['acertos'])->
        __set('erros',$_POST['erros'])->
        __set('id_simulado',$_POST['simulado']);
        $materiaService = new MateriaService($materia,$conexao);
        if($materiaService -> verificar($_POST['simulado'])){
            if($materiaService->inserir()){
                header('location:colocar_notas.php?materia='.$lista_materias[$chave+1].'&id='.$_GET['id'].'&simulado='.$_POST['simulado'].'&sucesso=sucessoRegistro');
            }
        }else{
            header('location:colocar_notas.php?materia='.$lista_materias[$chave+1].'&id='.$_GET['id'].'&simulado='.$_POST['simulado'].'&erro=falhaRegistro');
        }
        //essa função me retorna verdadeiro caso não haja um objeto com essas mesmas coisas e falso caso contrário

    }else{
        header('location:colocar_notas.php?erro=incompleto&id='.$_GET['id'].'&materia='.$lista_materias[$chave] );
    }
}else if($acao =='modifica_pagina'){
    //no post ele retorna um array([ver_materia]=>(nome_materia))
    //eu quero: acertos e erros de cada simulado em cada matéria e dps é só fazer a relação deles bonitinho com os nomes e etc
    
    //1°passo:  pegar o id_materia, id_simulado, acertos, erros
    if(isset($_POST['id_materia'])){
        $materia = new Materia;
        $materia->__set('id_usuario',$_GET['id'])->
        __set('id_materia',$_POST['id_materia']);
        $conexao = new Conexao;
        $materiaService = new MateriaService($materia, $conexao);
        $ids_necessarios= $materiaService->pegar_id_acertos_erros();
        $nomes = [];
        //isso aqui vai retornar todos as matérias com seus respectivos nosmes
        foreach($ids_necessarios as $ids){
            $nomes[]=$materiaService->pegar_nomes($ids);
        }
        session_start();
        $_SESSION['infos'] = $nomes;
        header('location:planejamento.php?acao=executar&id_simulado=');
    }

}else if($acao == 'adicionar_obs'){
    $materia = new Materia;
    $materia->__set('id_usuario',$_GET['id'])->
    __set('id_materia',$_GET['materia'])->
    __set('id_simulado',$_GET['simulado']);
    $conexao = new Conexao;
    $materiaService = new MateriaService($materia, $conexao);
    $id = $materiaService->pegar_ids(1);
    if($_POST['observacao'] != null){
        $observacao = new Observacao;
        $observacao->__set('observacao', $_POST['observacao'])->
        __set('tb_user_materia', $id);
        echo $observacao->__get('tb_user_materia');
        $conexao = new Conexao;
        $observacaoService = new ObservacaoService($observacao, $conexao);
        if($observacaoService->inserir()){
            header('location:planejamento.php?id='.$id);
        }else{
            header('location:planejamento.php?id='.$id.'&acao=erro');
        }
    }else{
        header('location:planejamento.php?id='.$id.'&acao=erro');
    }
}