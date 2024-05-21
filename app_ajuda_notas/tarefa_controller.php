<?php
require 'app_ajuda_notas/conexao.php';
require 'app_ajuda_notas/usuario.service.php';
require 'app_ajuda_notas/usuario.model.php';
$acao = isset($_GET['acao'])? $_GET['acao']:$acao;

//adicionar usuário
if($acao =='inserir'){
    if($_POST['nome'] !=null && $_POST['senha-signin']!=null && $_POST['email-signin'] != null){
        $usuario = new Usuario();
        $usuario->__set('nome',$_POST['nome'])
        ->__set('email',$_POST['email-signin'])
        ->__set('senha',$_POST['senha-signin']);
        $conexao = new Conexao();
        $usuarioService = new UsuarioService($conexao,$usuario);
        if($usuarioService->inserir()){
            $id = $usuarioService->verificar()->id_usuario;
            session_start();
            $_SESSION['codigo'] = 'autorizado';
            $_SESSION['id'] = $id;
            header('location:colocar_notas.php?id='.$id);
        }
    }else{
        header('location:index.php?erro=incompleto');
    }
}
//aqui é a ação que faz para verificar o login
if($acao == 'verificar'){
    if($_POST['nome-login'] !=null && $_POST['senha-login']!=null && $_POST['email-login'] != null){
        $usuario = new Usuario();
        $usuario->__set('nome',$_POST['nome-login'])
        ->__set('email',$_POST['email-login'])
        ->__set('senha',$_POST['senha-login']);
        $conexao = new Conexao();
        $usuarioService = new UsuarioService($conexao,$usuario);
        if($usuarioService->verificar()){
            //precisamos do id, pois assim conseguimos deixar as outras páginas melhores
            $id = $usuarioService->verificar()->id_usuario;
            session_start();
            $_SESSION['codigo'] = 'autorizado';
            $_SESSION['id'] = $id;
            header('location:colocar_notas.php?id='.$id);
        }else{
            header('location:login.php?erro=dados_errados');
        }
    }else{
        header('location:index.php?erro=incompleto');
    }


}
// if($acao == 'inserir'){
//     $usuario = new Usuario();
//     $usuario->__set('nome',$acao->nome);
// }