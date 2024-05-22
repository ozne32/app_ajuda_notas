<?php
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
        <meta charset="utf-8">
        <title>Planejamento</title>
        <script>
            function mostrarForm(id,simulado,materia){
                console.log(id,simulado,materia)
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
        <?if(isset($_GET['acao']) && $_GET['acao']=='executar'){?>
            <h3 class="display-3"><?=$infos[0]['materia']?></h3>
            <hr>
            <?foreach($infos as $info){?>
                <h3 class="display-4">SIMULADO:<?=$info['simulado']?></h3>
                <div class="row">
                    <p class="text-success col-md-6 lead font-weight-bold">acertos:<?=$info['acertos']?></p>
                    <p class="text-danger col-md-6 lead  font-weight-bold">erros:<?=$info['erros']?></p>
                </div>
                <div id="formulario_<?=$info['simulado']?>"></div>
                <!-- eu tenho o id usuário, id materia e não tenho o simulado, porém eu tenho o nome do simulado -->
                <?
                //observacao --> fazer algo melhor que isso 
                    // require '../app_ajuda_notas/conexao.php';
                    // require '../app_ajuda_notas/materia.model.php';
                    // require '../app_ajuda_notas/materia.service.php';
                    // //id_simulado
                    // $materia = new Materia;
                    // $materia->__set('id_usuario', $id)->
                    // __set('id_materia', $_POST['id_materia']);
                    // $conexao = new Conexao;
                    // $materiaService = new MateriaService($materia,$conexao);
                    // $query = 'Select id_simulado from tb_simulados where id_usuario = ? and id_materia = ?';
                    // $smtm = $this->conexao->prepare($query);
                    // $smtm->bindValue(1, $this->materia->id_usuario);
                    // $smtm->bindValue(2, $this->materia->id_materia);
                    // $smtm->execute();
                    // $id_simulado = $smtm->fetch()->id_simulado;
                    // $query = 'SELECT id_user_materia from tb_user_materia where id_simulado = ? and id_materia = ? and id_usuario = ?';
                    // $smtm = $this->conexao->prepare($query);
                    // $smtm->bindValue(1, $id_simulado);
                    // $smtm->bindValue(2, $materia->id_materia);
                    // $smtm->bindValue(3, $this->materia->id_usuario);
                    // $smtm->execute();
                    // $id_user_materia = $smtm->fetch(PDO::FETCH_OBJ)->id_user_materia;
                    // return $id_user_materia;
                ?>
                    <button  class="btn btn-primary " style="margin-left:80%" onclick="mostrarForm(<?=$_SESSION['id']?>,'<?=$info['simulado']?>','<?=$info['materia']?>')">+Observação</button>
                <hr>
            <?}?>
        <?}?>
    </main>
</html>