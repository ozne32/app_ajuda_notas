<?php
session_start();
$id = $_SESSION['id'];
if($_SESSION['codigo'] != 'autorizado'){
    header('location:index.php?erro=acesso');
}
if(isset($_GET['materia'])){
    $lista_materias = ['Física','Matematica','Interpretação textual','Química','Geografia','História', 'Sociologia','Literatura','Inglês','Filosofia','Biologia'];
    if(in_array($_GET['materia'], $lista_materias)){
        $materia = $_GET['materia'];
    }else{
        header('location:colocar_notas.php?id='.$id);
    }
}else{
    $materia ='Física';
}
?>

<html>
    <head>
        <!-- bootstrap link -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <script src="https://kit.fontawesome.com/1476decda1.js" crossorigin="anonymous"></script>

        <title>Colocar notas</title>
        <script>
            function editar(materia,id_usuario,id_simulado,acerto_erro,erros,acertos,key){
                console.log(key)
                console.log(acerto_erro)
               //form
               let form = document.createElement('form')
                form.action = `materia_controller.php?acao=editar&id_usuario=${id_usuario}&simulado=${id_simulado}&materia=${materia}&acertoOuErro=${acerto_erro}&acertos=${acertos}&erros=${erros}`
                form.method='post'
                form.className='row'
                //input
                let input =document.createElement('input')
                input.name='novo_valor'
                input.type = 'number'
                input.style = 'width:60px'
                //botão
                let button = document.createElement('button')
                button.className = 'btn btn-success'
                button.innerHTML = 'atualizar'
                button.type ='submit'
                form.appendChild(input)
                form.appendChild(button)
                document.getElementById(`valor-${acerto_erro}-${key}`).innerHTML = ''
                document.getElementById(`valor-${acerto_erro}-${key}`).appendChild(form)
                input.focus()
            }
        </script>
    </head>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Ajuda Notas</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="planejamento.php?id=<?=$id?>" class="nav-link ">Ver planejamento</a></li>
                <li class="nav-item"><a href="#" class="nav-link active">Colocar notas</a></li>
                <li class="nav-item"><a class="nav-link" href="encerrar_sessao.php">Encerrar sessão</a></li>
            </ul>
        </nav>
    </header>
    <body>
        <div class="container">
            <?if($materia != null){?>
            <form action="materia_controller.php?acao=adicionar&materia=<?=$materia?>&id=<?=$_GET['id']?>" method='post'>
                <div class="row mb-3 mt-3">
                    <?if(!isset($_GET['simulado'])){?>
                        <select class="form-control"  name="simulado">
                            <option value="0">--selecione o simulado--</option>
                            <option value="1">Enem</option>
                            <option value="2">Fuvest</option>
                            <option value="3">Unicamp</option>
                            <option value="4">Unesp</option>
                        </select>
                        <!-- <p class="col-md-4 font-weight-bold">Digite qual simulado quer inserir as notas:</p> -->
                        <!-- <input class="col-md-8" type="text" name = 'simulado' placeholder="Exemplo:ENEM, Fuvest"> -->
                    <?}?>
                    <?if(isset($_GET['simulado'])){?>
                        <?$nome_simulado = null;
                        switch($_GET['simulado']){
                            case 1: $nome_simulado = 'ENEM';break;
                            case 2: $nome_simulado = 'Fuvest';break;
                            case 3: $nome_simulado = 'Unicamp';break;
                            case 4: $nome_simulado = 'Unesp';break;
                        }
                            ?>
                        <input class="form-control" type="text" readonly="true" value="<?=$nome_simulado?>">
                        <input hidden="true" class="col-md-8" type="text" name ='simulado' readonly="true" value="<?=$_GET['simulado']?>" placeholder="Exemplo:ENEM, Fuvest">
                    <?}?>
                </div>
                <div class="row justify-content-around">
                    <p class="col-md-2 font-weight-bold"><?=$materia?>:</p>
                    <input type="number" class="form-control col-md-4 mr-auto" name="acertos" placeholder="acertos:">
                    <input type="number" class="form-control col-md-4 mr-auto" name="erros" placeholder="erros:">
                </div>
                <?if(isset($_GET['erro']) && $_GET['erro'] == 'falhaRegistro'){?>
                    <p class="text-danger">falha ao registrar a matéria</p>
                <?}?>
                <?if(isset($_GET['sucesso']) && $_GET['sucesso'] == 'sucessoRegistro'){?>
                    <p class="text-success">Conseguimos registrar a matéria</p>
                <?}?>
                <?if(isset($_GET['erro']) && $_GET['erro'] == 'Errobanco'){?>
                    <p class="text-danger">Aconteceu algum erro ao registrar. Por favor tente mais tarde </p>
                <?}?>
                <button class="btn btn-success" type="submit">Adicionar</button>
            </form>
            <?}?>
            <?if(isset($_GET['simulado'])){?>
            <table class="table table-striped mt-5">
                <thead>
                    <th class="col-md-3">Simulado</th>
                    <th class="col-md-3">matéria</th>
                    <th class="col-md-3">acertos</th>
                    <th class="col-md-3">erros</th>
                </thead>
                <tbody>
                    <?
                    require_once '../app_ajuda_notas/conexao.php';
                    $conexao = new Conexao;
                    $query = 'SELECT 
                    m.nome_materia, u.nome, um.acertos, um.erros, s.nome_simulado
                    from tb_user_materia as um 
                    inner join
                    tb_usuario as u on um.id_usuario = u.id_usuario
                    inner join 
                    tb_simulados as s on s.id_simulado= um.id_simulado
                    inner JOIN
                    tb_materias as m on m.id_materia = um.id_materia   
                    where u.id_usuario = ? and s.id_simulado = ?
                    ';
                    $smtm = $conexao->conectar()->prepare($query);
                    $smtm->bindValue(1,$_GET['id']);
                    $smtm->bindValue(2,$_GET['simulado']);
                    $smtm->execute();
                    $arquivos = $smtm->fetchAll(PDO::FETCH_OBJ);
                    foreach($arquivos as $key=>$valor){?>
                    <tr>
                        <td><?=$valor->nome_simulado?></td>
                        <td><?=$valor->nome_materia?></td>
                        <td id="valor-acertos-<?=$key?>"><?=$valor->acertos?>
                            <button class="btn btn-sm" onclick="editar('<?=$valor->nome_materia?>', <?=$_GET['id']?>, <?=$_GET['simulado']?>,'acertos',<?=$valor->acertos?>, <?=$valor->erros?>,<?=$key?>)">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button><div id="update"></div>
                        </td>
                        <td id="valor-erros-<?=$key?>"><?=$valor->erros?>
                            <button class='btn btn-outline' onclick="editar('<?=$valor->nome_materia?>', <?=$_GET['id']?>, <?=$_GET['simulado']?>,'erros',<?=$valor->acertos?>, <?=$valor->erros?>,<?=$key?>)">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
            <?}?>
        </div>
    </body>
</html>