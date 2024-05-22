<?php
    require '../app_ajuda_notas/conexao.php';
    $conexao = new Conexao;
    session_start();
    if($_SESSION['codigo'] != 'autorizado'){
        header('location:index.php?erro=acesso');
    }
    $infos = $_SESSION['infos'];
    $id = $_SESSION['id'];
    $lista_materias = ['Física','Matematica','Interpretação textual','Química','Geografia','História', 'Sociologia','Literatura','Inglês','Filosofia','Biologia'];  
?>
<html>
    <head>
        <!-- bootstrap link -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/1476decda1.js" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <title>Planejamento</title>
        <script>
            function mostrarForm(id,simulado,materia){
                //form
                let form = document.createElement('form')
                form.action = `materia_controller.php?acao=adicionar_obs&id=${id}&simulado=${simulado}&materia=${materia}`
                form.method='post'
                form.className='row'
                //input
                let input =document.createElement('input')
                input.name='observacao'
                input.type = 'text'
                input.className = 'form-control mb-3'
                //botão
                let button = document.createElement('button')
                button.className = 'btn btn-success'
                button.innerHTML = 'adicionar'
                button.type ='submit'
                form.appendChild(input)
                form.appendChild(button)
                document.getElementById('formulario_'+simulado).appendChild(form)
                input.focus()
            }
            function marcarConcluida(id,text_observacao,id_materia){
                window.location.href = `materia_controller.php?acao=marcarConcluida&id=${id}&text_observacao=${text_observacao}&materia=${id_materia}`;
            }
        </script>
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
        <?if(isset($_GET['acao']) && $_GET['acao']=='erro'){?>
            <div class="text-danget">preencha o campo de observacao</div>
        <?}?>
       <h3>Qual matéria deseja ver o planejamento ?</h3>
       <form action="materia_controller.php?acao=modifica_pagina&id=<?=$id?>" method="post">
            <select name="id_materia" class="form-control">
                    <option value="0">--matéria--</option>
                    <?foreach($lista_materias as $key=>$valor){?>
                        <option class="form-control" value="<?=$key + 1?>"> <?=$valor?> </option>
                    <?}?>
            </select>
            <button class="btn btn-primary  mt-3" type="submit">Ver sobre a matéria</button>
        </form>
        <?if(isset($_GET['erro']) && $_GET['erro'] = 'preenchimentoMateria'){?>
        <div class="text-danger">
            coloque uma matéria para ver as suas observações.
        </div>
        <?}?>
        <?if(isset($_GET['acao']) && $_GET['acao']=='executar' || isset($_GET['materia'])){?>
            <h3 class="display-3"><?=$infos[0]['materia']?></h3>
            <hr>
            <?foreach($infos as $key=>$info){?>
                <h3 class="display-4">SIMULADO:<?=$info['simulado']?></h3>
                <div class="row">
                    <p class="text-success col-md-6 lead font-weight-bold">acertos:<?=$info['acertos']?></p>
                    <p class="text-danger col-md-6 lead  font-weight-bold">erros:<?=$info['erros']?></p>
                </div>
                <div id="formulario_<?=$info['simulado']?>"></div>
                <!-- eu tenho o id usuário, id materia e não tenho o simulado, porém eu tenho o nome do simulado -->
                <? 
                    //id_simulado
                    $query = 'select um.id_user_materia from tb_user_materia as um WHERE id_simulado = ? and id_materia = ? and id_usuario =?;';
                    $smtm = $conexao->conectar()->prepare($query);
                    $smtm->bindValue(1, $_SESSION['ids1'][$key]);
                    $smtm->bindValue(2, $_SESSION['materia']);
                    $smtm->bindValue(3, $id);
                    $smtm->execute();
                    $id_user_materia = $smtm->fetch();
                    $id_final =  $id_user_materia['id_user_materia'];
                    $query = 'SELECT o.observacao from tb_user_materia as um inner join tb_observacao as o on um.id_user_materia = o.tb_user_materia where um.id_user_materia = ?';
                    $smtm = $conexao->conectar()->prepare($query);
                    $smtm->bindValue(1, $id_final);
                    $smtm->execute();
                    $observacoes = $smtm->fetchAll(PDO::FETCH_OBJ);
                ?>
                    <ul>
                        <?foreach($observacoes as $observacao){?>
                            <div class="row">
                                <li class="col-md-"><?=$observacao->observacao?></li>
                                <button class="ml-2 mb-2 btn btn-success btn-sm" onclick="marcarConcluida(<?=$id_final?>,'<?=$observacao->observacao?>',<?=$_SESSION['materia']?>)"><i class="fa-solid fa-check text-light "></i></button>
                            </div>
                        <?}?>
                    </ul>
                    <button  class="btn btn-primary " style="margin-left:80%" onclick="mostrarForm(<?=$_SESSION['id']?>,'<?=$info['simulado']?>','<?=$info['materia']?>')">+Observação</button>
                <hr>
            <?}?>
        <?}?>
    </main>
</html>