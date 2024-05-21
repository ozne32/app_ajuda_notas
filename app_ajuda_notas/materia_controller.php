<?php
require '../app_ajuda_notas/conexao.php';
require '../app_ajuda_notas/materia.model.php';
require '../app_ajuda_notas/materia.service.php';
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
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

}
