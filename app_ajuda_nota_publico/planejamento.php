<?php
    session_start();
    if($_SESSION['codigo'] != 'autorizado'){
        header('location:index.php?erro=acesso');
    }
    $id = $_SESSION['id'];
    $lista_materias = ['Física','Matematica','Interpretação textual','Química','Geografia','História', 'Sociologia','Literatura','Inglês','Filosofia','Biologia'];  
?>
<html>
    <head>
        <!-- bootstrap link -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <title>Planejamento</title>
    </head>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Ajuda Notas</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a  href="#" class="nav-link active">Planejamento</a></li>
                <li class="nav-item"><a  href="colocar_notas.php?id=<?=$_SESSION['id']?>" class="nav-link">Colocar notas</a></li>
                <li class="nav-item"><a class="nav-link" href="encerrar_sessao.php">Encerrar sessão</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
       <h3>Qual matéria deseja ver o planejamento ?</h3>
       <form action="materia_controller.php?acao=modifica_pagina&id=<?=$id?>" method="post">
            <select name="ver_materia" class="form-control">
                    <option value="0">--matéria--</option>
                    <?foreach($lista_materias as $valor){?>
                        <option class="form-control" value="<?=$valor?>"><?=$valor?></option>
                    <?}?>
            </select>
            <button class="btn btn-primary  mt-3" type="submit">Ver sobre a matéria</button>
        </form>
    </main>
</html>